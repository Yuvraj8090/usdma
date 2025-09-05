<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dham;
use App\Models\State;
use App\Models\District;
use Illuminate\Http\Request;

class DhamController extends Controller
{
    public function index()
    {
        // Load dhams with state & district relationships
        $dhams = Dham::with(['state', 'district'])->get();

        return view('admin.dhams.index', compact('dhams'));
    }

    public function create()
    {
        $states = State::where('is_active', true)->get();
        $districts = District::where('is_active', true)->get();

        return view('admin.dhams.create', compact('states', 'districts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'state_id'    => 'required|exists:states,id',
            'district_id' => 'required|exists:districts,id',
            'latitude'    => 'nullable|numeric',
            'longitude'   => 'nullable|numeric',
            'height'      => 'nullable|integer',
            'is_active'   => 'boolean',
            'is_winter'   => 'boolean',
        ]);

        Dham::create($validated);

        return redirect()->route('admin.dhams.index')->with('success', 'Dham created successfully.');
    }

    public function edit(Dham $dham)
    {
        $states = State::where('is_active', true)->get();
        $districts = District::where('is_active', true)->get();

        return view('admin.dhams.edit', compact('dham', 'states', 'districts'));
    }

    public function update(Request $request, Dham $dham)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'state_id'    => 'required|exists:states,id',
            'district_id' => 'required|exists:districts,id',
            'latitude'    => 'nullable|numeric',
            'longitude'   => 'nullable|numeric',
            'height'      => 'nullable|integer',
            'is_active'   => 'boolean',
            'is_winter'   => 'boolean',
        ]);

        $dham->update($validated);

        return redirect()->route('admin.dhams.index')->with('success', 'Dham updated successfully.');
    }

    public function destroy(Dham $dham)
    {
        $dham->delete();

        return redirect()->route('admin.dhams.index')->with('success', 'Dham deleted successfully.');
    }
}
