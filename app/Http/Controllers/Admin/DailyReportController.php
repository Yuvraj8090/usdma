<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DailyReport;
use App\Models\DailyReportsFillable;
use App\Models\District;
use Illuminate\Http\Request;

class DailyReportController extends Controller
{
    public function index(Request $request)
    {
        $query = DailyReport::with(['district', 'fillableCategory']);

        if ($request->filled('district_id')) {
            $query->where('district_id', $request->district_id);
        }

        if ($request->filled('fillable_id')) {
            $query->where('fillable_id', $request->fillable_id);
        }

        if ($request->filled('report_date')) {
            $query->whereDate('report_date', $request->report_date);
        }

        if ($request->filled('from_date')) {
            $query->whereDate('from_date', $request->from_date);
        }

        $reports = $query->orderBy('report_date', 'desc')->paginate(15);
        $districts = District::all();
        $fillables = DailyReportsFillable::all();

        return view('admin.daily_reports.index', compact('reports', 'districts', 'fillables'));
    }

    public function create()
    {
        $districts = District::all(); // rows
        $parents = DailyReportsFillable::with('children')
                    ->whereNull('parent_id')
                    ->get(); // top-level headers with children

        return view('admin.daily_reports.create', compact('districts', 'parents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'report_date' => 'required|date',
            'from_date'   => 'required|date',
            'reports'     => 'required|array',
        ]);

        foreach ($request->reports as $districtId => $childReports) {
            foreach ($childReports as $childId => $count) {
                if ($count !== null && $count !== '') {
                    DailyReport::create([
                        'district_id' => $districtId,
                        'fillable_id' => $childId,
                        'count'       => (int) $count,
                        'report_date' => $request->report_date,
                        'from_date'   => $request->from_date,
                    ]);
                }
            }
        }

        return redirect()->route('admin.daily_reports.index')
                         ->with('success', 'Daily reports added successfully.');
    }

    public function edit(DailyReport $dailyReport)
    {
        $districts = District::all();
        $fillables = DailyReportsFillable::all();

        return view('admin.daily_reports.edit', compact('dailyReport', 'districts', 'fillables'));
    }

    public function update(Request $request, DailyReport $dailyReport)
    {
        $request->validate([
            'district_id' => 'required|exists:districts,id',
            'fillable_id' => 'required|exists:daily_reports_fillable,id',
            'count'       => 'required|integer|min:0',
            'report_date' => 'required|date',
            'from_date'   => 'required|date',
        ]);

        $dailyReport->update($request->only('district_id', 'fillable_id', 'count', 'report_date', 'from_date'));

        return redirect()->route('admin.daily_reports.index')
                         ->with('success', 'Daily report updated successfully.');
    }

    public function destroy(DailyReport $dailyReport)
    {
        $dailyReport->delete();
        return redirect()->route('admin.daily_reports.index')
                         ->with('success', 'Daily report deleted successfully.');
    }
}
