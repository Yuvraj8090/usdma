<?php

namespace App\Http\Controllers;

use App\Models\HumanLoss;
use Illuminate\Http\Request;

class HumanLossController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'incident_id' => 'required|exists:incidents,id',
            'name' => 'required',
            'loss_type' => 'required',
        ]);

        HumanLoss::create([
            'incident_id' => $request->incident_id,
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

            // JSON Nominee
            'nominee' => [
                'name' => $request->nominee_name,
                'relation' => $request->nominee_relation,
                'age' => $request->nominee_age,
                'address' => $request->nominee_address,
                'number' => $request->nominee_number,
            ],
        ]);

        return back()->with('success', 'Human Loss record saved successfully!');
    }
}
