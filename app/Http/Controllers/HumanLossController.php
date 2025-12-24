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
            'name' => 'required|string|max:255',
            'loss_type' => 'required|in:died,missing,injured',
            'nominees' => 'array',
        ];

        if ($request->loss_type === 'died') {
            $rules['nominees.*.name'] = 'required|string';
            $rules['nominees.*.relation'] = 'required|string';
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

                // ✅ DEFAULT SAFE HANDLING
                'compensation_amount' => $request->filled('compensation_amount') ? $request->compensation_amount : 0,

                'compensation_received_date' => $request->filled('compensation_received_date') ? $request->compensation_received_date : null,

                'compensation_status' => $request->filled('compensation_status') ? $request->compensation_status : 'pending',

                'nominee' => $request->nominees ?? [],
            ]);

            return redirect()->back()->with('success', 'Human Loss record saved successfully!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Something went wrong: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit(HumanLoss $humanLoss)
    {
        return view('admin.human_loss.edit', compact('humanLoss'));
    }

    public function update(Request $request, HumanLoss $humanLoss)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'loss_type' => 'required|in:died,missing,injured',
            'nominees' => 'array',
        ];

        if ($request->loss_type === 'died') {
            $rules['nominees.*.name'] = 'required|string';
            $rules['nominees.*.relation'] = 'required|string';
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

                // ✅ DEFAULT SAFE HANDLING
                'compensation_amount' => $request->filled('compensation_amount') ? $request->compensation_amount : 0,

                'compensation_received_date' => $request->filled('compensation_received_date') ? $request->compensation_received_date : null,

                'compensation_status' => $request->filled('compensation_status') ? $request->compensation_status : 'pending',

                'nominee' => $request->nominees ?? [],
            ]);

            return redirect()->back()->with('success', 'Human Loss record updated successfully!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Something went wrong: ' . $e->getMessage())
                ->withInput();
        }
    }
}
