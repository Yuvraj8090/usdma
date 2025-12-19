<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HumanLoss extends Model
{
    protected $fillable = [
        'incident_id',
        'name',
        'age',
        'sex',
        'loss_type',
        'address',
        'state',
        'district',
        'compensation_amount',
        'compensation_received_date',
        'compensation_status',
        'nominee',
    ];

    protected $casts = [
        'nominee' => 'array', // <-- ensures $hl->nominee is always an array
        'compensation_received_date' => 'date',
    ];
}
