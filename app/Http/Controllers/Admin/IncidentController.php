<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Incident;
use App\Models\HumanLoss;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DB;

class IncidentController extends Controller
{
    public function index()
    {
        return view('admin.incidents.index', [
            'incidents' => Incident::orderBy('id', 'desc')->get()
        ]);
    }

    public function create()
    {
        return view('admin.incidents.create');
    }

    public function store(Request $request)
    {
        // FAST VALIDATION
        $request->validate([
            'incident_name'     => 'required|string|max:255',
            'location_details'  => 'nullable|string',
            'state'             => 'required|string|max:100',
            'district'          => 'required|string|max:100',
            'village'           => 'nullable|string|max:100',
            'lat'               => 'nullable|numeric',
            'lng'               => 'nullable|numeric',
            'incident_date'     => 'required|date',
            'incident_time'     => 'required',
            'big_animal_died'   => 'nullable|numeric',
            'small_animal_died' => 'nullable|numeric',
            'file'              => 'nullable|file|max:4096',
            'loss'              => 'nullable|array'
        ]);

        DB::transaction(function () use ($request) {

            // FAST FILE UPLOAD (NO HELPER)
            $filePath = $request->file('file')
                ? $request->file('file')->store('incidents', 'public')
                : null;

            // CREATE INCIDENT (FAST MASS ASSIGN)
            $incident = Incident::create([
                'incident_uid'     => Str::uuid(),
                'incident_name'    => $request->incident_name,
                'location_details' => $request->location_details,
                'state'            => $request->state,
                'district'         => $request->district,
                'village'          => $request->village,
                'lat'              => $request->lat,
                'lng'              => $request->lng,
                'incident_date'    => $request->incident_date,
                'incident_time'    => $request->incident_time,
                'file'             => $filePath,
                'big_animal_died'  => $request->big_animal_died,
                'small_animal_died'=> $request->small_animal_died,
            ]);

            // FASTEST POSSIBLE LOOP
            if ($request->loss) {
                foreach ($request->loss as $row) {

                    HumanLoss::create([
                        'incident_id' => $incident->id,

                        'name'        => $row['name'] ?? null,
                        'age'         => $row['age'] ?? null,
                        'sex'         => $row['sex'] ?? null,
                        'loss_type'   => $row['loss_type'] ?? null,
                        'address'     => $row['address'] ?? null,
                        'state'       => $row['state'] ?? null,
                        'district'    => $row['district'] ?? null,

                        'compensation_amount'        => $row['compensation_amount'] ?? null,
                        'compensation_received_date' => $row['compensation_received_date'] ?? null,
                        'compensation_status'        => $row['compensation_status'] ?? null,

                        'nominee' => [
                            'name'     => $row['nominee_name'] ?? null,
                            'relation' => $row['nominee_relation'] ?? null,
                            'age'      => $row['nominee_age'] ?? null,
                            'address'  => $row['nominee_address'] ?? null,
                            'number'   => $row['nominee_number'] ?? null,
                        ]
                    ]);
                }
            }
        });

        return redirect()
            ->route('admin.incidents.index')
            ->with('success', 'Incident + Human Loss saved successfully.');
    }


    public function edit(Incident $incident)
    {
        $incident->load('humanLosses');
        return view('admin.incidents.edit', compact('incident'));
    }


    public function update(Request $request, Incident $incident)
    {
        // SAME FAST VALIDATION
        $request->validate([
            'incident_name'     => 'required|string|max:255',
            'location_details'  => 'nullable|string',
            'state'             => 'required|string|max:100',
            'district'          => 'required|string|max:100',
            'village'           => 'nullable|string|max:100',
            'lat'               => 'nullable|numeric',
            'lng'               => 'nullable|numeric',
            'incident_date'     => 'required|date',
            'incident_time'     => 'required',
            'big_animal_died'   => 'nullable|numeric',
            'small_animal_died' => 'nullable|numeric',
            'file'              => 'nullable|file|max:4096',
        ]);

        // FAST FILE HANDLING
        $filePath = $request->file('file')
            ? $request->file('file')->store('incidents', 'public')
            : $incident->file;

        $incident->update([
            'incident_name'    => $request->incident_name,
            'location_details' => $request->location_details,
            'state'            => $request->state,
            'district'         => $request->district,
            'village'          => $request->village,
            'lat'              => $request->lat,
            'lng'              => $request->lng,
            'incident_date'    => $request->incident_date,
            'incident_time'    => $request->incident_time,
            'file'             => $filePath,
            'big_animal_died'  => $request->big_animal_died,
            'small_animal_died'=> $request->small_animal_died,
        ]);

        return redirect()
            ->route('admin.incidents.index')
            ->with('success', 'Incident updated successfully.');
    }


    public function destroy(Incident $incident)
    {
        $incident->delete();

        return redirect()
            ->route('admin.incidents.index')
            ->with('success', 'Incident deleted successfully.');
    }
}
