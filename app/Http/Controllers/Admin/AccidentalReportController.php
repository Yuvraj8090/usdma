<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccidentalReport;
use App\Models\AccidentalReportFillable;
use App\Models\District;
use Illuminate\Http\Request;

class AccidentalReportController extends Controller
{
    /**
     * Display a listing of reports.
     */
    public function index(Request $request)
{
    $query = AccidentalReport::with(['district', 'fillableCategory'])
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
    $parents   = AccidentalReportFillable::with('children')
        ->whereNull('parent_id')
        ->get();

    return view('admin.accidental_reports.index', compact('reports', 'districts', 'parents'));
}


    /**
     * Show form to create a new report.
     */
    public function create()
    {
        $districts = District::all();
        $parents   = AccidentalReportFillable::with('children')
            ->whereNull('parent_id')
            ->get();

        return view('admin.accidental_reports.create', compact('districts', 'parents'));
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
                    AccidentalReport::create([
                        'district_id' => $districtId,
                        'fillable_id' => $childId,
                        'count'       => $count,
                        'report_date' => $request->report_date,
                    ]);
                }
            }
        }

        return redirect()->route('admin.accidental_reports.index')
            ->with('success', 'Accidental reports added successfully.');
    }

    /**
     * Show form to edit a report.
     */
    public function edit(AccidentalReport $accidentalReport)
    {
        $districts = District::all();
        $fillables = AccidentalReportFillable::all();

        return view('admin.accidental_reports.edit', compact('accidentalReport', 'districts', 'fillables'));
    }

    /**
     * Update a report.
     */
    public function update(Request $request, AccidentalReport $accidentalReport)
    {
        $request->validate([
            'district_id' => 'required|exists:districts,id',
            'fillable_id' => 'required|exists:accidental_reports_fillable,id',
            'count'       => 'required|integer|min:0',
            'report_date' => 'required|date',
        ]);

        $accidentalReport->update($request->only('district_id', 'fillable_id', 'count', 'report_date'));

        return redirect()->route('admin.accidental_reports.index')
            ->with('success', 'Accidental report updated successfully.');
    }

    /**
     * Delete a report.
     */
    public function destroy(AccidentalReport $accidentalReport)
    {
        $accidentalReport->delete();

        return redirect()->route('admin.accidental_reports.index')
            ->with('success', 'Accidental report deleted successfully.');
    }
}
