<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
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
}
