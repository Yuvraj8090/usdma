<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\State;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    public function index(Request $request)
{
    $query = District::with('state');

    // 🔍 Search
    if ($request->filled('search')) {
        $query->where('name', 'like', '%' . $request->search . '%');
    }

    // 🟢 Filter by status
    if ($request->filled('status') && in_array($request->status, ['active', 'inactive'])) {
        $query->where('is_active', $request->status === 'active');
    }

    // 🌍 Filter by state
    if ($request->filled('state_id')) {
        $query->where('state_id', $request->state_id);
    }

    // 📄 Per page (default 10)
    $perPage = $request->get('per_page', 10);

    $districts = $query->latest()->paginate($perPage)->appends($request->all());
    $states = State::where('is_active', true)->get();

    return view('admin.districts.index', compact('districts', 'states'));
}


    public function create()
    {
        $states = State::where('is_active', true)->get();
        return view('admin.districts.create', compact('states'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255|unique:districts,name',
            'state_id' => 'required|exists:states,id',
            'is_active'=> 'boolean',
        ]);

        District::create($request->only(['name', 'state_id', 'is_active']));

        return redirect()->route('admin.districts.index')->with('success', 'District created successfully.');
    }

    public function edit(District $district)
    {
        $states = State::where('is_active', true)->get();
        return view('admin.districts.edit', compact('district','states'));
    }

    public function update(Request $request, District $district)
    {
        $request->validate([
            'name'     => 'required|string|max:255|unique:districts,name,' . $district->id,
            'state_id' => 'required|exists:states,id',
            'is_active'=> 'boolean',
        ]);

        $district->update($request->only(['name', 'state_id', 'is_active']));

        return redirect()->route('admin.districts.index')->with('success', 'District updated successfully.');
    }

    public function destroy(District $district)
    {
        $district->delete();
        return redirect()->route('admin.districts.index')->with('success', 'District deleted successfully.');
    }
}
