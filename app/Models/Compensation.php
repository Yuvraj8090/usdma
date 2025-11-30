<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Compensation extends Model
{
    protected $fillable = [
        'incident_id',
        'compensation_type',
        'status',
        'release_date',
        'amount',
    ];

    protected $casts = [
        'release_date' => 'date',
        'amount' => 'decimal:2',
    ];

    public function incident()
    {
        return $this->belongsTo(Incident::class);
    }
}
