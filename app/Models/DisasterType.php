<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DisasterType extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'incident_type_id', 'is_active'];


  public function incidentType()
    {
        return $this->belongsTo(IncidentType::class, 'incident_type_id');
    }

    public function incidents()
    {
        return $this->hasMany(Incident::class, 'disaster_type_id');
    }

}
