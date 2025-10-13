<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EquipmentCategory;
use Illuminate\Http\Request;

class EquipmentCategoryController extends Controller
{
    /**
     * Display a listing of the categories.
     */
    public function index()
    {
        $categories = EquipmentCategory::latest()->get();
        return view('admin.equipment_categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category.
     */
    public function create()
    {
        return view('admin.equipment_categories.create');
    }

    /**
     * Store a newly created category in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:equipment_categories,name|max:255',
        ]);

        EquipmentCategory::create($request->only('name'));

        return redirect()->route('admin.equipment_categories.index')
                         ->with('success', 'Equipment Category created successfully.');
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit(EquipmentCategory $equipment_category)
    {
        return view('admin.equipment_categories.edit', compact('equipment_category'));
    }

    /**
     * Update the specified category in storage.
     */
    public function update(Request $request, EquipmentCategory $equipment_category)
    {
        $request->validate([
            'name' => 'required|unique:equipment_categories,name,' . $equipment_category->id,
        ]);

        $equipment_category->update($request->only('name'));

        return redirect()->route('admin.equipment_categories.index')
                         ->with('success', 'Equipment Category updated successfully.');
    }

    /**
     * Remove the specified category from storage.
     */
    public function destroy(EquipmentCategory $equipment_category)
    {
        $equipment_category->delete();

        return redirect()->route('admin.equipment_categories.index')
                         ->with('success', 'Equipment Category deleted successfully.');
    }
}
