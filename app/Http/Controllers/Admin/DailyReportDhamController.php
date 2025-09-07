<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DailyReportDham;
use App\Models\DailyReportsFillable;
use App\Models\Dham;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DailyReportDhamController extends Controller
{
    /**
     * List all reports with filters
     */
    public function index(Request $request)
    {
        $reports   = $this->getFilteredReports($request, true); // paginated
        $dhams     = $this->getDhams();
        $fillables = $this->getFillables();

        return view('admin.daily_reports_dhams.index', compact('reports', 'dhams', 'fillables'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        $dhams   = $this->getDhams();
        $parents = $this->getFillableParents();

        return view('admin.daily_reports_dhams.create', compact('dhams', 'parents'));
    }

    /**
     * Store new reports
     */
    public function store(Request $request)
{
    $request->validate([
        'report_date' => 'required|date',
        'reports'     => 'required|array',
    ]);

    foreach ($request->reports as $dhamId => $childReports) {
        foreach ($childReports as $childId => $count) {
            if (!empty($count) && (int) $count > 0) {
                DailyReportDham::create([
                    'dham_id'     => $dhamId,
                    'fillable_id' => $childId,
                    'count'       => (int) $count,
                    'report_date' => $request->report_date,
                ]);
            }
        }
    }

    return redirect()
        ->route('admin.daily_reports_dhams.index')
        ->with('success', 'Daily reports for Dhams added successfully.');
}


    /**
     * Download or view PDF
     */


    public function downloadPdf(Request $request)
{
    [$fromDate, $endDate] = $this->getReportRange($request);

    // 🔹 Reports with aggregated counts
    $reports = DailyReportDham::withoutTrashed()
        ->selectRaw('dham_id, fillable_id, SUM(count) as total_count')
        ->whereBetween('report_date', [$fromDate, $endDate])
        ->groupBy('dham_id', 'fillable_id')
        ->get()
        ->keyBy(fn($r) => $r->dham_id . '_' . $r->fillable_id);

    // 🔹 Earliest entry date per dham (based on report_date now)
    $firstEntries = DailyReportDham::withoutTrashed()
        ->selectRaw('dham_id, MIN(report_date) as first_date')
        ->groupBy('dham_id')
        ->pluck('first_date', 'dham_id'); // => [dham_id => first_report_date]

    $dhams   = $this->getDhams();
    $parents = $this->getFillableParents();

    return view('admin.daily_reports_dhams.pdf', compact('reports', 'dhams', 'parents', 'firstEntries'))
        ->with('fromDate', $fromDate->toDateString())
        ->with('reportDate', $endDate->toDateString());
}




    /**
     * Show edit form
     */
    public function edit(DailyReportDham $daily_reports_dham)
    {
        $dhams     = $this->getDhams();
        $fillables = $this->getFillables();

        return view('admin.daily_reports_dhams.edit', [
            'dailyReportDham' => $daily_reports_dham,
            'dhams'           => $dhams,
            'fillables'       => $fillables,
        ]);
    }

    /**
     * Update report
     */
    public function update(Request $request, DailyReportDham $daily_reports_dham)
{
    $request->validate([
        'dham_id'     => 'required|exists:dhams,id',
        'fillable_id' => 'required|exists:daily_reports_fillable,id',
        'count'       => 'nullable|integer|min:1',
        'report_date' => 'required|date',
    ]);

    if ($request->count && (int) $request->count > 0) {
        $daily_reports_dham->update(
            $request->only('dham_id', 'fillable_id', 'count', 'report_date')
        );
        $msg = 'Daily report updated successfully.';
    } else {
        $msg = 'Update skipped because count is 0 or missing.';
    }

    return redirect()
        ->route('admin.daily_reports_dhams.index')
        ->with('success', $msg);
}


    /**
     * Soft delete
     */
    public function destroy(DailyReportDham $daily_reports_dham)
    {
        $daily_reports_dham->delete();

        return redirect()
            ->route('admin.daily_reports_dhams.index')
            ->with('success', 'Daily report deleted successfully.');
    }

    /**
     * Permanent delete
     */
    public function forceDestroy(DailyReportDham $daily_reports_dham)
    {
        $daily_reports_dham->forceDelete();

        return redirect()
            ->route('admin.daily_reports_dhams.index')
            ->with('success', 'Daily report permanently deleted.');
    }

    /* ======================================================
     * 🔹 PRIVATE HELPERS
     * ====================================================== */

    private function getDhams()
    {
        return Dham::withoutTrashed()->get();
    }

    private function getFillables()
    {
        return DailyReportsFillable::withoutTrashed()->get();
    }

    private function getFillableParents()
    {
        return DailyReportsFillable::with('children')
            ->whereNull('parent_id')
            ->withoutTrashed()
            ->get();
    }

    private function getFilteredReports(Request $request, bool $paginate = false)
    {
        $query = DailyReportDham::with(['dham', 'fillableCategory'])->withoutTrashed();

        if ($request->filled('dham_id')) {
            $query->where('dham_id', $request->dham_id);
        }

        if ($request->filled('fillable_id')) {
            $query->where('fillable_id', $request->fillable_id);
        }

        if ($request->filled('report_date')) {
            $query->whereDate('report_date', $request->report_date);
        }

        

        return $paginate
            ? $query->orderBy('report_date', 'desc')->paginate(15)
            : $query->orderBy('report_date', 'desc')->get();
    }

    /**
     * Get report range based on financial year and first entry
     */
   private function getReportRange(Request $request): array
{
    $year = $request->input('year', now()->year);

    $financialYearStart = Carbon::createFromDate($year, 4, 1)->startOfDay();
    $endDate = $request->filled('report_date')
        ? Carbon::parse($request->report_date)->endOfDay()
        : now()->endOfDay();

    return [$financialYearStart, $endDate];
}

}
