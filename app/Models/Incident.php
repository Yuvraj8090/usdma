<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    protected $fillable = [
        'incident_uid',
        'incident_name',

        // Types
        'incident_type_id',
        'disaster_type_id',

        'steps',
        'incident_through',
        'state',
        'district',
        'village',
        'latitude',
        'longitude',
        'incident_date',
        'incident_time',

        // Animal loss
        'big_animals_died',
        'small_animals_died',
        'hen_count',
        'other_animal_count',

        // House damage
        'partially_house',
        'severely_house',
        'fully_house',
        'cowshed_house',
        'hut_count',

        // Agriculture & infrastructure
        'agriculture_land_loss_hectare',
        'helicopter_sorties',
        'electricity_line_damage',
        'water_pipeline_damage',
        'road_damage',

        // Rehabilitation
        'punha_sthapanna_road',

        // File
        'file_path',
    ];

    protected $casts = [
        'incident_date' => 'date',
        'incident_time' => 'datetime:H:i',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    // One Incident -> Many Human Losses
    public function humanLosses()
    {
        return $this->hasMany(HumanLoss::class, 'incident_id');
    }

    // Incident → Incident Type
    public function incidentType()
    {
        return $this->belongsTo(IncidentType::class, 'incident_type_id');
    }

    // Incident → Disaster Type
    public function disasterType()
    {
        return $this->belongsTo(DisasterType::class, 'disaster_type_id');
    }
}
