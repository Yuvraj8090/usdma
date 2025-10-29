<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NaturalDisasterReportsFillable;
use Illuminate\Http\Request;

class NaturalDisasterReportsFillableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = NaturalDisasterReportsFillable::query()->with('children');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $fillables = $query->paginate(15);

        return view('admin.natural_disaster_reports_fillable.index', compact('fillables'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parents = NaturalDisasterReportsFillable::whereNull('parent_id')->get();
        return view('admin.natural_disaster_reports_fillable.create', compact('parents'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_id'   => 'nullable|exists:natural_disaster_reports_fillable,id',
            'is_active'   => 'boolean',
        ]);

        NaturalDisasterReportsFillable::create($request->only('name', 'description', 'parent_id', 'is_active'));

        return redirect()->route('admin.natural-disaster-fillable.index')
                         ->with('success', 'Natural disaster category created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NaturalDisasterReportsFillable $fillable)
    {
        $parents = NaturalDisasterReportsFillable::whereNull('parent_id')
                    ->where('id', '!=', $fillable->id)
                    ->get();

        return view('admin.natural_disaster_reports_fillable.edit', compact('fillable', 'parents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, NaturalDisasterReportsFillable $fillable)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_id'   => 'nullable|exists:natural_disaster_reports_fillable,id',
            'is_active'   => 'boolean',
        ]);

        $fillable->update($request->only('name', 'description', 'parent_id', 'is_active'));

        return redirect()->route('admin.natural-disaster-fillable.index')
                         ->with('success', 'Natural disaster category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NaturalDisasterReportsFillable $fillable)
    {
        $fillable->delete();

        return redirect()->route('admin.natural-disaster-fillable.index')
                         ->with('success', 'Natural disaster category deleted successfully.');
    }
}
