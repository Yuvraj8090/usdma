<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DisasterType;
use App\Models\Incident;
use App\Models\HumanLoss;
use App\Models\IncidentType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DB;
use App\Models\State;
use App\Models\District;
use Yajra\DataTables\Facades\DataTables;
class IncidentController extends Controller
{
    /**
     * List all incidents
     */

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $incidents = Incident::with(['humanLosses', 'incidentType:id,name', 'disasterType:id,name'])->select('incidents.*');

            return DataTables::of($incidents)
                ->addColumn('incident_type', fn($i) => $i->incidentType->name ?? 'N/A')
                ->addColumn('disaster_type', fn($i) => $i->disasterType->name ?? 'N/A')
                ->addColumn('died', fn($i) => $i->humanLosses->where('loss_type', 'died')->count())
                ->addColumn('missing', fn($i) => $i->humanLosses->where('loss_type', 'missing')->count())
                ->addColumn('injured', fn($i) => $i->humanLosses->where('loss_type', 'injured')->count())
                ->addColumn('actions', fn($incident) => view('admin.incidents.partials.actions', compact('incident'))->render())
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('admin.incidents.index');
    }

    /**
     * Create page
     */

    public function create()
    {
        $incidentTypes = IncidentType::active()->with('disasterTypes:id,incident_type_id,name')->orderBy('name')->get();

        $states = State::where('is_active', true)->orderBy('name')->get();

        return view('admin.incidents.create', compact('incidentTypes', 'states'));
    }

    /**
     * Store new incident
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'incident_name' => 'required|string|max:255',
            'incident_type_id' => 'required|exists:incident_types,id',
            'disaster_type_id' => 'required|exists:disaster_types,id',

            'state' => 'required|string|max:100',
            'district' => 'required|string|max:100',
            'village' => 'nullable|string|max:100',

            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',

            'incident_date' => 'required|date',
            'incident_time' => 'required',

            // Animal loss
            'big_animals_died' => 'nullable|integer|min:0',
            'small_animals_died' => 'nullable|integer|min:0',
            'hen_count' => 'nullable|integer|min:0',
            'other_animal_count' => 'nullable|integer|min:0',

            // House damage
            'partially_house' => 'nullable|integer|min:0',
            'severely_house' => 'nullable|integer|min:0',
            'fully_house' => 'nullable|integer|min:0',
            'cowshed_house' => 'nullable|integer|min:0',
            'hut_count' => 'nullable|integer|min:0',

            // Infrastructure
            'agriculture_land_loss_hectare' => 'nullable|numeric|min:0',
            'helicopter_sorties' => 'nullable|integer|min:0',
            'electricity_line_damage' => 'nullable|integer|min:0',
            'water_pipeline_damage' => 'nullable|integer|min:0',
            'road_damage' => 'nullable|integer|min:0',

            'punha_sthapanna_road' => 'nullable|string|max:255',

            'file' => 'nullable|file|max:4096',
            'loss' => 'nullable|array',
        ]);

        DB::transaction(function () use ($request, $validated) {
            if ($request->hasFile('file')) {
                $validated['file_path'] = $request->file('file')->store('incidents', 'public');
            }

            $validated['incident_uid'] = Str::uuid();

            $incident = Incident::create($validated);

            if ($request->filled('loss')) {
                foreach ($request->loss as $row) {
                    $incident->humanLosses()->create([
                        'name' => $row['name'] ?? null,
                        'age' => $row['age'] ?? null,
                        'sex' => $row['sex'] ?? null,
                        'loss_type' => $row['loss_type'] ?? null,
                        'address' => $row['address'] ?? null,
                        'state' => $row['state'] ?? null,
                        'district' => $row['district'] ?? null,
                        'compensation_amount' => $row['compensation_amount'] ?? null,
                        'compensation_received_date' => $row['compensation_received_date'] ?? null,
                        'compensation_status' => $row['compensation_status'] ?? null,
                        'nominee' => [
                            'name' => $row['nominee_name'] ?? null,
                            'relation' => $row['nominee_relation'] ?? null,
                            'age' => $row['nominee_age'] ?? null,
                            'address' => $row['nominee_address'] ?? null,
                            'number' => $row['nominee_number'] ?? null,
                        ],
                    ]);
                }
            }
        });

        return redirect()->route('admin.incidents.index')->with('success', 'Incident created successfully.');
    }

    /**
     * Edit page
     */
    public function edit(Incident $incident)
    {
        $incident->load(['humanLosses', 'incidentType', 'disasterType']);
        $states= State::all();
        $districts = District::all();
        $disasterTypes =DisasterType::all();

        $incidentTypes = IncidentType::active()->with('disasterTypes:id,incident_type_id,name')->orderBy('name')->get();

        return view('admin.incidents.edit', compact('incident', 'incidentTypes','states','disasterTypes','districts'));
    }

    /**
     * Update incident
     */
    public function update(Request $request, Incident $incident)
    {
        $validated = $request->validate([
            'incident_name' => 'required|string|max:255',
            'incident_type_id' => 'required|exists:incident_types,id',
            'disaster_type_id' => 'required|exists:disaster_types,id',

            'state' => 'required|string|max:100',
            'district' => 'required|string|max:100',
            'village' => 'nullable|string|max:100',

            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',

            'incident_date' => 'required|date',
            'incident_time' => 'required',

            'punha_sthapanna_road' => 'nullable|string|max:255',
            'file' => 'nullable|file|max:4096',
        ]);

        if ($request->hasFile('file')) {
            $validated['file_path'] = $request->file('file')->store('incidents', 'public');
        }

        $incident->update($validated);

        return redirect()->route('admin.incidents.index')->with('success', 'Incident updated successfully.');
    }

    /**
     * Delete incident
     */
    public function destroy(Incident $incident)
    {
        $incident->delete();

        return redirect()->route('admin.incidents.index')->with('success', 'Incident deleted successfully.');
    }
}
