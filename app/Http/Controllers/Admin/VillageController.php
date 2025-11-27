<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Village;
use App\Models\Tehsil;
use Illuminate\Http\Request;

class VillageController extends Controller
{
    public function index(Request $request)
    {
        $query = Village::with('tehsil');

        // Search filter
        if ($request->search) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        // Tehsil filter
        if ($request->tehsil_id) {
            $query->where('tehsil_id', $request->tehsil_id);
        }

        // Status filter
        if ($request->status === 'active') {
            $query->where('is_active', 1);
        } elseif ($request->status === 'inactive') {
            $query->where('is_active', 0);
        }

        $villages = $query->paginate($request->per_page ?? 10);
        $tehsils = Tehsil::all();

        return view('admin.villages.index', compact('villages', 'tehsils'));
    }

    public function create()
    {
        $tehsils = Tehsil::all();
        return view('admin.villages.create', compact('tehsils'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'tehsil_id' => 'required|exists:tehsils,id',
        ]);

        Village::create([
            'name' => $request->name,
            'tehsil_id' => $request->tehsil_id,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.villages.index')->with('success', 'Village created successfully');
    }

    public function edit(Village $village)
    {
        $tehsils = Tehsil::all();
        return view('admin.villages.edit', compact('village', 'tehsils'));
    }

    public function update(Request $request, Village $village)
    {
        $request->validate([
            'name' => 'required',
            'tehsil_id' => 'required|exists:tehsils,id',
        ]);

        $village->update([
            'name' => $request->name,
            'tehsil_id' => $request->tehsil_id,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.villages.index')->with('success', 'Village updated successfully');
    }

    public function destroy(Village $village)
    {
        $village->delete();
        return redirect()->route('admin.villages.index')->with('success', 'Village deleted');
    }
}
