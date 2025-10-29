<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NaturalDisasterReport;
use App\Models\NaturalDisasterReportsFillable;
use App\Models\District;
use Illuminate\Http\Request;

class NaturalDisasterReportController extends Controller
{
    /**
     * Display a listing of reports.
     */
    public function index(Request $request)
    {
        $query = NaturalDisasterReport::with(['district', 'fillableCategory'])
            ->selectRaw('district_id, fillable_id, report_date, SUM(count) as total_count')
            ->groupBy('district_id', 'fillable_id', 'report_date');

        if ($request->filled('district_id')) {
            $query->where('district_id', $request->district_id);
        }

        if ($request->filled('fillable_id')) {
            $query->where('fillable_id', $request->fillable_id);
        }

        if ($request->filled('report_date')) {
            $query->whereDate('report_date', $request->report_date);
        }

        $reports   = $query->orderBy('report_date', 'desc')->paginate(15);
        $districts = District::all();
        $parents   = NaturalDisasterReportsFillable::with('children')
            ->whereNull('parent_id')
            ->get();

        return view('admin.natural_disaster_reports.index', compact('reports', 'districts', 'parents'));
    }

    /**
     * Show form to create a new report.
     */
    public function create()
    {
        $districts = District::all();
        $parents   = NaturalDisasterReportsFillable::with('children')
            ->whereNull('parent_id')
            ->get();

        return view('admin.natural_disaster_reports.create', compact('districts', 'parents'));
    }

    /**
     * Store new reports in bulk.
     */
    public function store(Request $request)
    {
        $request->validate([
            'report_date' => 'required|date',
            'reports'     => 'required|array',
        ]);

        foreach ($request->reports as $districtId => $childReports) {
            foreach ($childReports as $childId => $reportData) {
                $count = (int)($reportData['count'] ?? 0);

                if ($count > 0) {
                    NaturalDisasterReport::create([
                        'district_id' => $districtId,
                        'fillable_id' => $childId,
                        'count'       => $count,
                        'report_date' => $request->report_date,
                    ]);
                }
            }
        }

        return redirect()->route('admin.natural-disaster-reports.index')
            ->with('success', 'Natural disaster reports added successfully.');
    }

    /**
     * Show form to edit a report.
     */
    public function edit(NaturalDisasterReport $naturalDisasterReport)
    {
        $districts = District::all();
        $fillables = NaturalDisasterReportsFillable::all();

        return view('admin.natural_disaster_reports.edit', compact('naturalDisasterReport', 'districts', 'fillables'));
    }

    /**
     * Update a report.
     */
    public function update(Request $request, NaturalDisasterReport $naturalDisasterReport)
    {
        $request->validate([
            'district_id' => 'required|exists:districts,id',
            'fillable_id' => 'required|exists:natural_disaster_reports_fillable,id',
            'count'       => 'required|integer|min:0',
            'report_date' => 'required|date',
        ]);

        $naturalDisasterReport->update($request->only('district_id', 'fillable_id', 'count', 'report_date'));

        return redirect()->route('admin.natural-disaster-reports.index')
            ->with('success', 'Natural disaster report updated successfully.');
    }

    /**
     * Delete a report.
     */
    public function destroy(NaturalDisasterReport $naturalDisasterReport)
    {
        $naturalDisasterReport->delete();

        return redirect()->route('admin.natural-disaster-reports.index')
            ->with('success', 'Natural disaster report deleted successfully.');
    }
}
