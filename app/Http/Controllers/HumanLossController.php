<?php

namespace App\Http\Controllers;

use App\Models\HumanLoss;
use Illuminate\Http\Request;

class HumanLossController extends Controller
{
    public function create($incidentId)
    {
        $humanLosses = HumanLoss::where('incident_id', $incidentId)->get();
        return view('admin.human_loss.create', compact('incidentId', 'humanLosses'));
    }

    public function nomineeRow(Request $request)
{
    $i = $request->query('i', 0);
    $nominee = $request->query('nominee');
    $nominee = $nominee ? json_decode($nominee, true) : null;

    return view('admin.human_loss.partials.nominee-row', compact('i', 'nominee'));
}


    public function store(Request $request, $incidentId)
    {
        $rules = [
            'name' => 'required',
            'loss_type' => 'required',
            'nominees' => 'array',
        ];

        if ($request->loss_type === 'died') {
            $rules['nominees.*.name'] = 'required';
            $rules['nominees.*.relation'] = 'required';
        }

        $request->validate($rules);

        try {
            HumanLoss::create([
                'incident_id' => $incidentId,
                'name' => $request->name,
                'age' => $request->age,
                'sex' => $request->sex,
                'loss_type' => $request->loss_type,
                'address' => $request->address,
                'state' => $request->state,
                'district' => $request->district,
                'compensation_amount' => $request->compensation_amount,
                'compensation_received_date' => $request->compensation_received_date,
                'compensation_status' => $request->compensation_status,
                'nominee' => $request->nominees,
            ]);

            return redirect()->back()->with('success', 'Human Loss record saved successfully!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage())->withInput();
        }
    }

    public function edit(HumanLoss $humanLoss)
    {
        return view('admin.human_loss.edit', compact('humanLoss'));
    }

    public function update(Request $request, HumanLoss $humanLoss)
    {
        $rules = [
            'name' => 'required',
            'loss_type' => 'required',
            'nominees' => 'array',
        ];

        if ($request->loss_type === 'died') {
            $rules['nominees.*.name'] = 'required';
            $rules['nominees.*.relation'] = 'required';
        }

        $request->validate($rules);

        try {
            $humanLoss->update([
                'name' => $request->name,
                'age' => $request->age,
                'sex' => $request->sex,
                'loss_type' => $request->loss_type,
                'address' => $request->address,
                'state' => $request->state,
                'district' => $request->district,
                'compensation_amount' => $request->compensation_amount,
                'compensation_received_date' => $request->compensation_received_date,
                'compensation_status' => $request->compensation_status,
                'nominee' => $request->nominees,
            ]);

            return redirect()->back()->with('success', 'Human Loss record updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong: '.$e->getMessage())->withInput();
        }
    }
}
