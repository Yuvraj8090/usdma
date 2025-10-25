<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Season;
use Illuminate\Http\Request;

class SeasonController extends Controller
{
    public function index()
    {
        $seasons = Season::orderBy('start_date', 'asc')->get();
        return view('admin.seasons.index', compact('seasons'));
    }

    public function create()
    {
        return view('admin.seasons.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'season_type' => 'required|string|max:100',
        ]);

        Season::create($validated);
        return redirect()->route('admin.seasons.index')->with('success', 'Season created successfully.');
    }

    public function show(Season $season)
    {
        return view('admin.seasons.show', compact('season'));
    }

    public function edit(Season $season)
    {
        return view('admin.seasons.edit', compact('season'));
    }

    public function update(Request $request, Season $season)
    {
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'season_type' => 'required|string|max:100',
        ]);

        $season->update($validated);
        return redirect()->route('admin.seasons.index')->with('success', 'Season updated successfully.');
    }

    public function destroy(Season $season)
    {
        $season->delete();
        return redirect()->route('admin.seasons.index')->with('success', 'Season deleted successfully.');
    }
}
