<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IncidentType extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'is_active'];

    // Relationship
    public function incidents()
    {
        return $this->hasMany(Incident::class, 'incident_type_id');
    }

    // 🔥 Add this method
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }
}
