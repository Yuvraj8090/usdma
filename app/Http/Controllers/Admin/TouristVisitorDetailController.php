<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TouristVisitorDetail;
use App\Models\Dham;
use Illuminate\Http\Request;

class TouristVisitorDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $visitorDetails = TouristVisitorDetail::with('dham')->latest()->paginate(20);
        return view('admin.tourist_visitor_details.index', compact('visitorDetails'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dhams = Dham::where('is_active', true)->orderBy('name')->get();
        return view('admin.tourist_visitor_details.create', compact('dhams'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'location_id' => 'required|exists:dhams,id',
            'date' => 'required|date',
            'reporting_time' => 'required',
            'men' => 'nullable|integer|min:0',
            'women' => 'nullable|integer|min:0',
            'children' => 'nullable|integer|min:0',
            'foreign_men' => 'nullable|integer|min:0',
            'foreign_women' => 'nullable|integer|min:0',
            'foreign_children' => 'nullable|integer|min:0',
            'no_of_pilgrims' => 'nullable|integer|min:0',
            'no_of_vehicles' => 'nullable|integer|min:0',
            'dead_due_health' => 'nullable|integer|min:0',
            'dead_due_nature' => 'nullable|integer|min:0',
            'dead_today' => 'nullable|integer|min:0',
            'missing_due_health' => 'nullable|integer|min:0',
            'missing_due_nature' => 'nullable|integer|min:0',
            'missing_today' => 'nullable|integer|min:0',
            'pilgrims_till_date' => 'nullable|integer|min:0',
            'vehicles_till_date' => 'nullable|integer|min:0',
            'dead_till_date' => 'nullable|integer|min:0',
            'missing_till_date' => 'nullable|integer|min:0',
            'entry_date' => 'nullable|date',
            'is_active' => 'boolean',
        ]);

        TouristVisitorDetail::create($validated);

        return redirect()->route('admin.tourist-visitor-details.index')
            ->with('success', 'Tourist visitor details added successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TouristVisitorDetail $touristVisitorDetail)
    {
        $dhams = Dham::where('is_active', true)->orderBy('name')->get();
        return view('admin.tourist_visitor_details.edit', compact('touristVisitorDetail', 'dhams'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TouristVisitorDetail $touristVisitorDetail)
    {
        $validated = $request->validate([
            'location_id' => 'required|exists:dhams,id',
            'date' => 'required|date',
            'reporting_time' => 'required',
            'men' => 'nullable|integer|min:0',
            'women' => 'nullable|integer|min:0',
            'children' => 'nullable|integer|min:0',
            'foreign_men' => 'nullable|integer|min:0',
            'foreign_women' => 'nullable|integer|min:0',
            'foreign_children' => 'nullable|integer|min:0',
            'no_of_pilgrims' => 'nullable|integer|min:0',
            'no_of_vehicles' => 'nullable|integer|min:0',
            'dead_due_health' => 'nullable|integer|min:0',
            'dead_due_nature' => 'nullable|integer|min:0',
            'dead_today' => 'nullable|integer|min:0',
            'missing_due_health' => 'nullable|integer|min:0',
            'missing_due_nature' => 'nullable|integer|min:0',
            'missing_today' => 'nullable|integer|min:0',
            'pilgrims_till_date' => 'nullable|integer|min:0',
            'vehicles_till_date' => 'nullable|integer|min:0',
            'dead_till_date' => 'nullable|integer|min:0',
            'missing_till_date' => 'nullable|integer|min:0',
            'entry_date' => 'nullable|date',
            'is_active' => 'boolean',
        ]);

        $touristVisitorDetail->update($validated);

        return redirect()->route('admin.tourist-visitor-details.index')
            ->with('success', 'Tourist visitor details updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TouristVisitorDetail $touristVisitorDetail)
    {
        $touristVisitorDetail->delete();

        return redirect()->route('admin.tourist-visitor-details.index')
            ->with('success', 'Tourist visitor detail deleted successfully.');
    }
}
