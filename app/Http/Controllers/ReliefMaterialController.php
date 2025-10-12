<?php

namespace App\Http\Controllers;

use App\Models\ReliefMaterial;
use App\Models\District;
use App\Http\Requests\StoreReliefMaterialRequest;
use App\Http\Requests\UpdateReliefMaterialRequest;

class ReliefMaterialController extends Controller
{
    /**
     * Display a listing of relief materials.
     */
    public function index()
    {
        $reliefMaterials = ReliefMaterial::with('district') // eager load district
            ->latest()
            ->get();

        return view('admin.relief_material.index', compact('reliefMaterials'));
    }

    /**
     * Show the form for creating a new relief material.
     */
    public function create()
    {
        $districts = District::orderBy('name')->get();

        return view('admin.relief_material.create', compact('districts'));
    }

    /**
     * Store a newly created relief material in storage.
     */
    public function store(StoreReliefMaterialRequest $request)
    {
        ReliefMaterial::create($request->validated());

        return redirect()
            ->route('admin.relief_material.index')
            ->with('success', 'Relief Material created successfully.');
    }

    /**
     * Display the specified relief material.
     */
    public function show(ReliefMaterial $reliefMaterial)
    {
        return view('admin.relief_material.show', compact('reliefMaterial'));
    }

    /**
     * Show the form for editing the specified relief material.
     */
    public function edit(ReliefMaterial $reliefMaterial)
    {
        $districts = District::orderBy('name')->get();

        return view('admin.relief_material.edit', compact('reliefMaterial', 'districts'));
    }

    /**
     * Update the specified relief material in storage.
     */
    public function update(UpdateReliefMaterialRequest $request, ReliefMaterial $reliefMaterial)
    {
        $reliefMaterial->update($request->validated());

        return redirect()
            ->route('admin.relief_material.index')
            ->with('success', 'Relief Material updated successfully.');
    }

    /**
     * Remove the specified relief material from storage.
     */
    public function destroy(ReliefMaterial $reliefMaterial)
    {
        $reliefMaterial->delete();

        return redirect()
            ->route('admin.relief_material.index')
            ->with('success', 'Relief Material deleted successfully.');
    }
}
