<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyLoss extends Model
{
    protected $fillable = [
        'incident_id',
        'property_type_id',
        'loss_type',
        'description',
    ];

    public function incident()
    {
        return $this->belongsTo(Incident::class);
    }

    public function propertyType()
    {
        return $this->belongsTo(PropertyType::class);
    }
}
