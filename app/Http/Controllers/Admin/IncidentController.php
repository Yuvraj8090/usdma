<?php

namespace App\Http\Controllers\Admin;

use App\Models\Incident;
use App\Models\Nominee;
use App\Models\AnimalLoss;
use App\Models\PropertyLoss;
use App\Models\PropertyType;
use App\Models\Compensation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IncidentController extends Controller
{
    // LIST ALL INCIDENTS
    public function index()
    {
        $incidents = Incident::latest()->paginate(20);
        return view('admin.incidents.index', compact('incidents'));
    }

    // CREATE FORM
    public function create()
    {
        $propertyTypes = PropertyType::all();
        return view('admin.incidents.create', compact('propertyTypes'));
    }

    // STORE RECORD
    public function store(Request $request)
    {
        $incident = Incident::create($request->only([
            'incident_type', 'name', 'gender', 'age', 'date',
            'time', 'state', 'address', 'reason', 'loss_details'
        ]));

        // NOMINEE (For Human)
        if ($request->incident_type === 'human') {
            $incident->nominee()->create($request->only(['nominee_name', 'nominee_relation', 'nominee_address']));
        }

        // ANIMAL LOSS
        if ($request->incident_type === 'animal') {
            $incident->animalLoss()->create($request->only(['big_animals', 'small_animals']));
        }

        // PROPERTY LOSS
        if ($request->incident_type === 'property') {
            $incident->propertyLosses()->create($request->only([
                'property_type_id', 'loss_type', 'description'
            ]));
        }

        // COMPENSATION
        $incident->compensation()->create($request->only([
            'compensation_type', 'status', 'release_date', 'amount'
        ]));

        return redirect()->route('admin.incidents.index')
            ->with('success', 'Incident recorded successfully!');
    }

    // EDIT FORM
    public function edit($id)
    {
        $incident = Incident::with(['nominee','animalLoss','propertyLosses','compensation'])->findOrFail($id);
        $propertyTypes = PropertyType::all();

        return view('admin.incidents.edit', compact('incident','propertyTypes'));
    }

    // UPDATE RECORD
    public function update(Request $request, $id)
    {
        $incident = Incident::findOrFail($id);

        $incident->update($request->only([
            'incident_type','name','gender','age','date','time','state','address','reason','loss_details'
        ]));

        // Update related records based on type
        if ($incident->incident_type === 'human') {
            $incident->nominee()->updateOrCreate([], $request->only([
                'nominee_name','nominee_relation','nominee_address'
            ]));
        }

        if ($incident->incident_type === 'animal') {
            $incident->animalLoss()->updateOrCreate([], $request->only([
                'big_animals','small_animals'
            ]));
        }

        if ($incident->incident_type === 'property') {
            $incident->propertyLosses()->delete(); // reset old data
            $incident->propertyLosses()->create($request->only([
                'property_type_id','loss_type','description'
            ]));
        }

        $incident->compensation()->updateOrCreate([], $request->only([
            'compensation_type','status','release_date','amount'
        ]));

        return redirect()->route('admin.incidents.index')
            ->with('success', 'Incident updated successfully!');
    }

    // DELETE RECORD
    public function destroy($id)
    {
        Incident::findOrFail($id)->delete();

        return redirect()->route('admin.incidents.index')
            ->with('success', 'Incident deleted successfully!');
    }
}
