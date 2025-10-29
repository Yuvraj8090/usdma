<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RoadClosedFillable;
use Illuminate\Http\Request;

class RoadClosedFillableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = RoadClosedFillable::query()->with('children');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $fillables = $query->paginate(15);

        return view('admin.road_closed_fillable.index', compact('fillables'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parents = RoadClosedFillable::whereNull('parent_id')->get();
        return view('admin.road_closed_fillable.create', compact('parents'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_id'   => 'nullable|exists:road_closed_fillables,id',
            'is_active'   => 'boolean',
        ]);

        RoadClosedFillable::create($request->only('name', 'description', 'parent_id', 'is_active'));

        return redirect()->route('admin.road-closed-fillable.index')
                         ->with('success', 'Road Closed category created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RoadClosedFillable $roadClosedFillable)
    {
        $parents = RoadClosedFillable::whereNull('parent_id')
                                     ->where('id', '!=', $roadClosedFillable->id)
                                     ->get();

        return view('admin.road_closed_fillable.edit', compact('roadClosedFillable', 'parents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RoadClosedFillable $roadClosedFillable)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_id'   => 'nullable|exists:road_closed_fillables,id',
            'is_active'   => 'boolean',
        ]);

        $roadClosedFillable->update($request->only('name', 'description', 'parent_id', 'is_active'));

        return redirect()->route('admin.road-closed-fillable.index')
                         ->with('success', 'Road Closed category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RoadClosedFillable $roadClosedFillable)
    {
        $roadClosedFillable->delete();

        return redirect()->route('admin.road-closed-fillable.index')
                         ->with('success', 'Road Closed category deleted successfully.');
    }
}
