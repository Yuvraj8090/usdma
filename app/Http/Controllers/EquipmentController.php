<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\District;
use App\Models\EquipmentCategory;
use App\Models\Activity;
use App\Models\ResourceType;
use App\Http\Requests\StoreEquipmentRequest;
use App\Http\Requests\UpdateEquipmentRequest;

class EquipmentController extends Controller
{
    public function index()
    {
        $equipments = Equipment::with(['district', 'category', 'activity', 'resourceType'])
            ->latest()
            ->paginate(10);

        return view('admin.equipment.index', compact('equipments'));
    }

    public function create()
    {
        $districts = District::orderBy('name')->get();
        $categories = EquipmentCategory::orderBy('name')->get();
        $activities = Activity::orderBy('activity_name')->get();
        $resourceTypes = ResourceType::orderBy('resource_type')->get();

        return view('admin.equipment.create', compact('districts', 'categories', 'activities', 'resourceTypes'));
    }

    public function store(StoreEquipmentRequest $request)
    {
        try {
            Equipment::create($request->validated());
            return redirect()->route('admin.equipment.index')
                ->with('success', 'Equipment created successfully.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error creating equipment: ' . $e->getMessage());
        }
    }

    public function show(Equipment $equipment)
    {
        $equipment->load(['district', 'category', 'activity', 'resourceType']);
        return view('admin.equipment.show', compact('equipment'));
    }

    public function edit(Equipment $equipment)
    {
        $districts = District::orderBy('name')->get();
        $categories = EquipmentCategory::orderBy('name')->get();
        $activities = Activity::orderBy('name')->get();
        $resourceTypes = ResourceType::orderBy('name')->get();

        return view('admin.equipment.edit', compact('equipment', 'districts', 'categories', 'activities', 'resourceTypes'));
    }

    public function update(UpdateEquipmentRequest $request, Equipment $equipment)
    {
        try {
            $equipment->update($request->validated());
            return redirect()->route('admin.equipment.index')
                ->with('success', 'Equipment updated successfully.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error updating equipment: ' . $e->getMessage());
        }
    }

    public function destroy(Equipment $equipment)
    {
        try {
            $equipment->delete();
            return redirect()->route('admin.equipment.index')
                ->with('success', 'Equipment deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error deleting equipment: ' . $e->getMessage());
        }
    }
}
