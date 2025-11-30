<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    protected $fillable = [
        'incident_type',
        'name',
        'gender',
        'age',
        'date',
        'time',
        'state',
        'address',
        'loss_details',
        'reason',
    ];

    protected $casts = [
        'loss_details' => 'array',
        'date' => 'date',
        'time' => 'datetime:H:i',
    ];

    // ---- RELATIONSHIPS ---- //

    public function nominee()
    {
        return $this->hasOne(Nominee::class);
    }

    public function compensation()
    {
        return $this->hasOne(Compensation::class);
    }

    public function animalLoss()
    {
        return $this->hasOne(AnimalLoss::class);
    }

    public function propertyLosses()
    {
        return $this->hasMany(PropertyLoss::class);
    }
}
