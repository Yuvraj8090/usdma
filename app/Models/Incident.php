<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    // No timestamps if your table doesn’t use created_at / updated_at
    // public $timestamps = false;

    protected $fillable = [
        'incident_uid',
        'incident_name',
        'steps',
        'incident_through',

        'state',
        'district',
        'village',

        'latitude',
        'longitude',

        'incident_date',
        'incident_time',

        'big_animals_died',
        'small_animals_died',

        'file_path',
    ];

    /**
     * Relationship: One Incident -> Many Human Loss
     */
    public function humanLosses()
    {
        return $this->hasMany(HumanLoss::class, 'incident_id');
    }
}
