<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnimalLoss extends Model
{
    protected $fillable = [
        'incident_id',
        'big_animals',
        'small_animals',
    ];

    public function incident()
    {
        return $this->belongsTo(Incident::class);
    }
}
