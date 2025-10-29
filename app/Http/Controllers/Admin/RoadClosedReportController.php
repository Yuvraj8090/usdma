<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RoadClosedReport;
use App\Models\RoadClosedFillable;
use App\Models\District;
use Illuminate\Http\Request;

class RoadClosedReportController extends Controller
{
    /**
     * Display a listing of reports.
     */
    public function index(Request $request)
{
    $query = RoadClosedReport::with(['district', 'fillableItem'])
        ->selectRaw('district_id, fillable_id, report_date, GROUP_CONCAT(data SEPARATOR ", ") as all_data')
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
    $parents   = RoadClosedFillable::with('children')->whereNull('parent_id')->get();

    return view('admin.road_closed_reports.index', compact('reports', 'districts', 'parents'));
}


    /**
     * Show form to create a new report.
     */
    public function create()
    {
        $districts = District::all();
        $parents   = RoadClosedFillable::with('children')->whereNull('parent_id')->get();

        return view('admin.road_closed_reports.create', compact('districts', 'parents'));
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
                $data = trim($reportData['data'] ?? '');

                if (!empty($data)) {
                    RoadClosedReport::create([
                        'district_id' => $districtId,
                        'fillable_id' => $childId,
                        'data'        => $data,
                        'report_date' => $request->report_date,
                    ]);
                }
            }
        }

        return redirect()->route('admin.road-closed-reports.index')
            ->with('success', 'Road Closed reports added successfully.');
    }

    /**
     * Show form to edit a report.
     */
    public function edit(RoadClosedReport $roadClosedReport)
    {
        $districts = District::all();
        $fillables = RoadClosedFillable::all();

        return view('admin.road_closed_reports.edit', compact('roadClosedReport', 'districts', 'fillables'));
    }

    /**
     * Update a report.
     */
    public function update(Request $request, RoadClosedReport $roadClosedReport)
    {
        $request->validate([
            'district_id' => 'required|exists:districts,id',
            'fillable_id' => 'required|exists:road_closed_fillables,id',
            'data'        => 'required|string',
            'report_date' => 'required|date',
        ]);

        $roadClosedReport->update($request->only('district_id', 'fillable_id', 'data', 'report_date'));

        return redirect()->route('admin.road-closed-reports.index')
            ->with('success', 'Road Closed report updated successfully.');
    }

    /**
     * Delete a report.
     */
    public function destroy(RoadClosedReport $roadClosedReport)
    {
        $roadClosedReport->delete();

        return redirect()->route('admin.road-closed-reports.index')
            ->with('success', 'Road Closed report deleted successfully.');
    }
}
