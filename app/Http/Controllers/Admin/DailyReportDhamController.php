<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{
    DailyReportDham,
    DailyReportsFillable,
    Dham,
    AccidentalReport,
    AccidentalReportFillable,
    District
};
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class DailyReportDhamController extends Controller
{
    /**
     * List all reports with filters
     */
    public function index(Request $request)
    {
        $reports = $this->getFilteredReports($request, true);
        $dhams = $this->getDhams();
        $fillables = $this->getFillables();

        return view('admin.daily_reports_dhams.index', compact('reports', 'dhams', 'fillables'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        return view('admin.daily_reports_dhams.create', [
            'dhams' => $this->getDhams(),
            'parents' => $this->getFillableParents()
        ]);
    }

    /**
     * Store new reports
     */
    public function store(Request $request)
    {
        $request->validate([
            'report_date' => 'required|date',
            'reports' => 'required|array',
        ]);

        $this->insertDhamReports($request->report_date, $request->reports);

        return redirect()
            ->route('admin.daily_reports_dhams.index')
            ->with('success', 'Daily reports for Dhams added successfully.');
    }

    /**
     * Download or view PDF
     */
    public function downloadPdf(Request $request)
    {
        [$reportDate, $year] = $this->getReportDateAndYear($request);

        // Cached data for reuse (improves performance)
        $dhams = $this->getDhams();
        $dhamParents = $this->getFillableParents();
        $districts = $this->getDistricts();
        $accidentalParents = $this->getAccidentalParents();

        // Dham reports
        $dhamReports = $this->getDhamReports($reportDate);
        $firstDhamEntries = $this->getFirstDhamEntries();

        // Accidental reports
        [$financialYearStart, $latestAccidentalDate] = $this->getAccidentalDateRange($year);
        $accidentalReports = $this->getAccidentalReports($financialYearStart, $latestAccidentalDate);
        $firstAccidentalEntries = $this->getFirstAccidentalEntries($financialYearStart);
$fromDate = Carbon::parse($request->get('report_date'))->copy()->startOfMonth();
$toDate = Carbon::parse($request->get('report_date'));
        return view('admin.daily_reports_dhams.pdf', compact(
            'reportDate',
            'financialYearStart',
            'latestAccidentalDate',
            'dhamReports',
            'dhams',
            'fromDate',
    'toDate',
            'dhamParents',
            'firstDhamEntries',
            'accidentalReports',
            'districts',
            'accidentalParents',
            'firstAccidentalEntries'
        ));
    }

    /**
     * Edit a specific report
     */
    public function edit(DailyReportDham $daily_reports_dham)
    {
        return view('admin.daily_reports_dhams.edit', [
            'dailyReportDham' => $daily_reports_dham,
            'dhams' => $this->getDhams(),
            'fillables' => $this->getFillables(),
        ]);
    }

    /**
     * Update report
     */
    public function update(Request $request, DailyReportDham $daily_reports_dham)
    {
        $request->validate([
            'dham_id' => 'required|exists:dhams,id',
            'fillable_id' => 'required|exists:daily_reports_fillable,id',
            'count' => 'nullable|integer|min:1',
            'report_date' => 'required|date',
        ]);

        if ($request->count > 0) {
            $daily_reports_dham->update($request->only('dham_id', 'fillable_id', 'count', 'report_date'));
            $msg = 'Daily report updated successfully.';
        } else {
            $msg = 'Update skipped because count is 0 or missing.';
        }

        return redirect()->route('admin.daily_reports_dhams.index')->with('success', $msg);
    }

    /**
     * Soft delete
     */
    public function destroy(DailyReportDham $daily_reports_dham)
    {
        $daily_reports_dham->delete();
        return back()->with('success', 'Daily report deleted successfully.');
    }

    /**
     * Permanent delete
     */
    public function forceDestroy(DailyReportDham $daily_reports_dham)
    {
        $daily_reports_dham->forceDelete();
        return back()->with('success', 'Daily report permanently deleted.');
    }

    /* ======================================================
     * 🔹 PRIVATE HELPER FUNCTIONS
     * ====================================================== */

    /** Cached data accessors (5 min cache to reduce DB hits) */
    private function getDhams()       { return Cache::remember('dhams', 300, fn() => Dham::withoutTrashed()->get()); }
    private function getFillables()   { return Cache::remember('fillables', 300, fn() => DailyReportsFillable::withoutTrashed()->get()); }
    private function getFillableParents() { return Cache::remember('fillable_parents', 300, fn() => DailyReportsFillable::with('children')->whereNull('parent_id')->withoutTrashed()->get()); }
    private function getDistricts()   { return Cache::remember('districts', 300, fn() => District::withoutTrashed()->get()); }
    private function getAccidentalParents() { return Cache::remember('accidental_parents', 300, fn() => AccidentalReportFillable::with('children')->whereNull('parent_id')->withoutTrashed()->get()); }

    /** Insert new dham reports efficiently */
    private function insertDhamReports(string $reportDate, array $reports): void
    {
        $insertData = [];

        foreach ($reports as $dhamId => $childReports) {
            foreach ($childReports as $childId => $count) {
                $count = (int) $count;
                if ($count > 0) {
                    $insertData[] = [
                        'dham_id' => $dhamId,
                        'fillable_id' => $childId,
                        'count' => $count,
                        'report_date' => $reportDate,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }

        if (!empty($insertData)) {
            DailyReportDham::insert($insertData);
        }
    }

    /** Get Dham reports for a given date */
    private function getDhamReports(Carbon $reportDate)
    {
        return DailyReportDham::withoutTrashed()
            ->selectRaw('dham_id, fillable_id, SUM(count) as total_count')
            ->whereDate('report_date', $reportDate)
            ->groupBy('dham_id', 'fillable_id')
            ->get()
            ->keyBy(fn($r) => $r->dham_id . '_' . $r->fillable_id);
    }

    /** Get first report per Dham */
    private function getFirstDhamEntries()
    {
        return DailyReportDham::withoutTrashed()
            ->selectRaw('dham_id, MIN(report_date) as first_date')
            ->groupBy('dham_id')
            ->pluck('first_date', 'dham_id');
    }

    /** Get date and year info */
    private function getReportDateAndYear(Request $request): array
    {
        $reportDate = Carbon::parse($request->get('report_date', now()));
        $year = $request->get('year', $reportDate->year);
        return [$reportDate, $year];
    }

    /** Get accidental report date range */
    private function getAccidentalDateRange(int $year): array
    {
        $financialYearStart = Carbon::createFromDate($year, 4, 1);
        $latestAccidentalDate = AccidentalReport::withoutTrashed()->max('report_date');
        return [$financialYearStart, $latestAccidentalDate];
    }

    /** Get accidental reports */
    private function getAccidentalReports(Carbon $start, ?string $end)
    {
        if (!$end) return collect();

        return AccidentalReport::withoutTrashed()
            ->whereBetween('report_date', [$start, $end])
            ->selectRaw('district_id, fillable_id, SUM(count) as total_count')
            ->groupBy('district_id', 'fillable_id')
            ->get()
            ->groupBy('district_id');
    }

    /** Get first accidental entries */
    private function getFirstAccidentalEntries(Carbon $start)
    {
        return AccidentalReport::withoutTrashed()
            ->where('report_date', '>=', $start)
            ->selectRaw('district_id, MIN(report_date) as first_date')
            ->groupBy('district_id')
            ->pluck('first_date', 'district_id');
    }

    /** Apply filters for listing */
    private function getFilteredReports(Request $request, bool $paginate = false)
    {
        $query = DailyReportDham::with(['dham', 'fillableCategory'])->withoutTrashed();

        foreach (['dham_id', 'fillable_id', 'report_date'] as $filter) {
            if ($request->filled($filter)) {
                $query->where($filter === 'report_date' ? fn($q) => $q->whereDate($filter, $request->$filter) : $filter, $request->$filter);
            }
        }

        return $paginate
            ? $query->latest('report_date')->paginate(15)
            : $query->latest('report_date')->get();
    }
}
