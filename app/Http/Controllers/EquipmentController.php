<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\District;
use App\Models\EquipmentCategory;
use App\Models\Activity;
use App\Models\ResourceType;
use App\Http\Requests\StoreEquipmentRequest;
use App\Http\Requests\UpdateEquipmentRequest;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $equipments = Equipment::with(['district', 'category', 'activity', 'resourceType'])->latest();

            return DataTables::of($equipments)
                ->addColumn('district', fn($e) => $e->district->name ?? '-')
                ->addColumn('category', fn($e) => $e->category->name ?? '-')
                ->addColumn('activity', fn($e) => $e->activity->activity_name ?? '-')
                ->addColumn('resource_type', fn($e) => $e->resourceType->resource_type ?? '-')
                ->addColumn('quantity', fn($e) => '<span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full '
                    . ($e->quantity > 10 ? 'bg-green-100 text-green-800' : ($e->quantity > 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800'))
                    . '">' . $e->quantity . '</span>')
                ->addColumn('status', fn($e) => '<span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full '
                    . ($e->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800')
                    . '">' . ($e->is_active ? 'Active' : 'Inactive') . '</span>')
                ->addColumn('action', fn($e) => '
                    <a href="' . route('admin.equipment.edit', $e->id) . '" class="text-blue-600 hover:text-blue-900"><i class="fas fa-edit"></i></a>
                    <form action="' . route('admin.equipment.destroy', $e->id) . '" method="POST" class="inline" onsubmit="return confirm(\'Are you sure?\')">
                        ' . csrf_field() . method_field('DELETE') . '
                        <button type="submit" class="text-red-600 hover:text-red-900"><i class="fas fa-trash"></i></button>
                    </form>
                ')
                ->rawColumns(['quantity', 'status', 'action'])
                ->make(true);
        }

        return view('admin.equipment.index');
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
        Equipment::create($request->validated());
        return redirect()->route('admin.equipment.index')->with('success', 'Equipment created successfully.');
    }

    public function edit(Equipment $equipment)
    {
        $districts = District::orderBy('name')->get();
        $categories = EquipmentCategory::orderBy('name')->get();
        $activities = Activity::orderBy('activity_name')->get();
        $resourceTypes = ResourceType::orderBy('resource_type')->get();

        return view('admin.equipment.edit', compact('equipment', 'districts', 'categories', 'activities', 'resourceTypes'));
    }

    public function update(UpdateEquipmentRequest $request, Equipment $equipment)
    {
        $equipment->update($request->validated());
        return redirect()->route('admin.equipment.index')->with('success', 'Equipment updated successfully.');
    }

    public function destroy(Equipment $equipment)
    {
        $equipment->delete();
        return redirect()->route('admin.equipment.index')->with('success', 'Equipment deleted successfully.');
    }
}
