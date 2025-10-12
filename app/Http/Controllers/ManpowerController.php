<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Manpower;
use App\Http\Requests\StoreManpowerRequest;
use App\Http\Requests\UpdateManpowerRequest;

class ManpowerController extends Controller
{
    /**
     * Display a listing of the manpower.
     */
    public function index()
    {
        $manpower = Manpower::with('district')->latest()->get();
        return view('admin.manpower.index', compact('manpower'));
    }

    /**
     * Show the form for creating a new manpower record.
     */

    /**
     * Store a newly created manpower record.
     */
    public function store(StoreManpowerRequest $request)
    {
        Manpower::create($request->validated());

        return redirect()->route('admin.manpower.index')->with('success', 'Manpower created successfully.');
    }

    /**
     * Display the specified manpower record.
     */
    public function show(Manpower $manpower)
    {
        return view('admin.manpower.show', compact('manpower'));
    }

    /**
     * Show the form for editing the specified manpower record.
     */
    public function create()
    {
        $districts = \App\Models\District::all();
        return view('admin.manpower.create', compact('districts'));
    }

    public function edit(Manpower $manpower)
    {
        $districts = \App\Models\District::all();
        return view('admin.manpower.edit', compact('manpower', 'districts'));
    }

    /**
     * Update the specified manpower record.
     */
    public function update(UpdateManpowerRequest $request, Manpower $manpower)
    {
        $manpower->update($request->validated());

        return redirect()->route('admin.manpower.index')->with('success', 'Manpower updated successfully.');
    }

    /**
     * Remove the specified manpower record.
     */
    public function destroy(Manpower $manpower)
    {
        $manpower->delete();

        return redirect()->route('admin.manpower.index')->with('success', 'Manpower deleted successfully.');
    }
}
