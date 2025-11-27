<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IncidentType;
use Illuminate\Http\Request;

class IncidentTypeController extends Controller
{
    // List all incident types
    public function index(Request $request)
    {
        $query = IncidentType::query();

        // 🔍 Search by name
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // 🟢 Filter by status
        if ($request->filled('status') && in_array($request->status, ['active', 'inactive'])) {
            $query->where('is_active', $request->status === 'active');
        }

        // 📄 Pagination (default 10)
        $perPage = $request->get('per_page', 10);
        $incidentTypes = $query->latest()->paginate($perPage)->appends($request->all());

        return view('admin.incident_types.index', compact('incidentTypes'));
    }

    // Show create form
    public function create()
    {
        return view('admin.incident_types.create');
    }

    // Store new incident type
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:incident_types,name',
            'is_active' => 'boolean',
        ]);

        IncidentType::create($request->only(['name', 'is_active']));

        return redirect()->route('admin.incident-types.index')->with('success', 'Incident Type created successfully.');
    }

    // Show edit form
    public function edit(IncidentType $incidentType)
    {
        return view('admin.incident_types.edit', compact('incidentType'));
    }

    // Update existing incident type
    public function update(Request $request, IncidentType $incidentType)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:incident_types,name,' . $incidentType->id,
            'is_active' => 'boolean',
        ]);

        $incidentType->update($request->only(['name', 'is_active']));

        return redirect()->route('admin.incident-types.index')->with('success', 'Incident Type updated successfully.');
    }

    // Soft delete incident type
    public function destroy(IncidentType $incidentType)
    {
        $incidentType->delete();

        return redirect()->route('admin.incident-types.index')->with('success', 'Incident Type deleted successfully.');
    }
}
