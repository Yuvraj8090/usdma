<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\State;
use Illuminate\Http\Request;

class StateController extends Controller
{
    /**
     * Display a listing of the states.
     */
    public function index()
    {
        $states = State::latest()->paginate(10);
        return view('admin.states.index', compact('states'));
    }

    /**
     * Show the form for creating a new state.
     */
    public function create()
    {
        return view('admin.states.create');
    }

    /**
     * Store a newly created state in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255|unique:states,name',
            'is_active' => 'boolean',
        ]);

        State::create($request->only(['name', 'is_active']));

        return redirect()->route('admin.states.index')
                         ->with('success', 'State created successfully.');
    }

    /**
     * Show the form for editing the specified state.
     */
    public function edit(State $state)
    {
        return view('admin.states.edit', compact('state'));
    }

    /**
     * Update the specified state in storage.
     */
    public function update(Request $request, State $state)
    {
        $request->validate([
            'name'      => 'required|string|max:255|unique:states,name,' . $state->id,
            'is_active' => 'boolean',
        ]);

        $state->update($request->only(['name', 'is_active']));

        return redirect()->route('admin.states.index')
                         ->with('success', 'State updated successfully.');
    }

    /**
     * Soft delete the specified state from storage.
     */
    public function destroy(State $state)
    {
        $state->delete();

        return redirect()->route('admin.states.index')
                         ->with('success', 'State deleted successfully.');
    }
}
