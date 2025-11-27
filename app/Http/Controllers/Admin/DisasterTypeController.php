<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DisasterType;
use App\Models\IncidentType;
use Illuminate\Http\Request;

class DisasterTypeController extends Controller
{
    // List all disaster types
    public function index(Request $request)
    {
        $query = DisasterType::with('incidentType');

        // 🔍 Search by name
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // 🟢 Filter by status
        if ($request->filled('status') && in_array($request->status, ['active', 'inactive'])) {
            $query->where('is_active', $request->status === 'active');
        }

        // 🌍 Filter by incident type
        if ($request->filled('incident_type_id')) {
            $query->where('incident_type_id', $request->incident_type_id);
        }

        // 📄 Pagination (default 10)
        $perPage = $request->get('per_page', 10);
        $disasterTypes = $query->latest()->paginate($perPage)->appends($request->all());

        $incidentTypes = IncidentType::where('is_active', true)->get();

        return view('admin.disaster_types.index', compact('disasterTypes', 'incidentTypes'));
    }

    // Show create form
    public function create()
    {
        $incidentTypes = IncidentType::where('is_active', true)->get();
        return view('admin.disaster_types.create', compact('incidentTypes'));
    }

    // Store new disaster type
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:disaster_types,name',
            'incident_type_id' => 'nullable|exists:incident_types,id',
            'is_active' => 'boolean',
        ]);

        DisasterType::create($request->only(['name', 'incident_type_id', 'is_active']));

        return redirect()->route('admin.disaster-types.index')->with('success', 'Disaster Type created successfully.');
    }

    // Show edit form
    public function edit(DisasterType $disasterType)
    {
        $incidentTypes = IncidentType::where('is_active', true)->get();
        return view('admin.disaster_types.edit', compact('disasterType', 'incidentTypes'));
    }

    // Update existing disaster type
    public function update(Request $request, DisasterType $disasterType)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:disaster_types,name,' . $disasterType->id,
            'incident_type_id' => 'nullable|exists:incident_types,id',
            'is_active' => 'boolean',
        ]);

        $disasterType->update($request->only(['name', 'incident_type_id', 'is_active']));

        return redirect()->route('admin.disaster-types.index')->with('success', 'Disaster Type updated successfully.');
    }

    // Soft delete disaster type
    public function destroy(DisasterType $disasterType)
    {
        $disasterType->delete();

        return redirect()->route('admin.disaster-types.index')->with('success', 'Disaster Type deleted successfully.');
    }
}
