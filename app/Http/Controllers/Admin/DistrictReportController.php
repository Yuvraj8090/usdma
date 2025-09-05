<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DistrictReport;
use App\Models\District;
use Illuminate\Http\Request;

class DistrictReportController extends Controller
{
    public function index()
    {
        // Load reports with district relationship
        $reports = DistrictReport::with('district')->latest()->get();

        return view('admin.district_reports.index', compact('reports'));
    }

    public function create()
    {
        $districts = District::where('is_active', true)->get();

        return view('admin.district_reports.create', compact('districts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'district_id' => 'required|exists:districts,id',
            'body'        => 'required|string',
            'submit_date' => 'required|date',
        ]);

        DistrictReport::create($validated);

        return redirect()->route('admin.district-reports.index')->with('success', 'Report created successfully.');
    }

    public function edit(DistrictReport $districtReport)
    {
        $districts = District::where('is_active', true)->get();

        return view('admin.district_reports.edit', compact('districtReport', 'districts'));
    }

    public function update(Request $request, DistrictReport $districtReport)
    {
        $validated = $request->validate([
            'district_id' => 'required|exists:districts,id',
            'body'        => 'required|string',
            'submit_date' => 'required|date',
        ]);

        $districtReport->update($validated);

        return redirect()->route('admin.district-reports.index')->with('success', 'Report updated successfully.');
    }

    public function destroy(DistrictReport $districtReport)
    {
        $districtReport->delete();

        return redirect()->route('admin.district-reports.index')->with('success', 'Report deleted successfully.');
    }
}
