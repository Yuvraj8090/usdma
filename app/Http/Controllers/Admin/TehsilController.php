<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tehsil;
use App\Models\District;
use Illuminate\Http\Request;

class TehsilController extends Controller
{
    /**
     * Display a listing of the tehsils.
     */
    public function index(Request $request)
    {
        $query = Tehsil::with('district');

        // 🔍 Search by name
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // 🟢 Filter by active / inactive
        if ($request->filled('status') && in_array($request->status, ['active', 'inactive'])) {
            $query->where('is_active', $request->status === 'active');
        }

        // 🌍 Filter by district
        if ($request->filled('district_id')) {
            $query->where('district_id', $request->district_id);
        }

        // 📄 Pagination (default: 10)
        $perPage = $request->get('per_page', 10);

        $tehsils = $query->latest()->paginate($perPage)->appends($request->all());
        $districts = District::where('is_active', true)->get();

        return view('admin.tehsils.index', compact('tehsils', 'districts'));
    }

    /**
     * Show the form for creating a new tehsil.
     */
    public function create()
    {
        $districts = District::where('is_active', true)->get();
        return view('admin.tehsils.create', compact('districts'));
    }

    /**
     * Store a new tehsil.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255|unique:tehsils,name',
            'district_id' => 'required|exists:districts,id',
            'is_active'   => 'boolean',
        ]);

        Tehsil::create($request->only(['name', 'district_id', 'is_active']));

        return redirect()->route('admin.tehsils.index')->with('success', 'Tehsil created successfully.');
    }

    /**
     * Show the form for editing an existing tehsil.
     */
    public function edit(Tehsil $tehsil)
    {
        $districts = District::where('is_active', true)->get();
        return view('admin.tehsils.edit', compact('tehsil', 'districts'));
    }

    /**
     * Update the tehsil.
     */
    public function update(Request $request, Tehsil $tehsil)
    {
        $request->validate([
            'name'        => 'required|string|max:255|unique:tehsils,name,' . $tehsil->id,
            'district_id' => 'required|exists:districts,id',
            'is_active'   => 'boolean',
        ]);

        $tehsil->update($request->only(['name', 'district_id', 'is_active']));

        return redirect()->route('admin.tehsils.index')->with('success', 'Tehsil updated successfully.');
    }

    /**
     * Soft delete the tehsil.
     */
    public function destroy(Tehsil $tehsil)
    {
        $tehsil->delete();
        return redirect()->route('admin.tehsils.index')->with('success', 'Tehsil deleted successfully.');
    }
}
