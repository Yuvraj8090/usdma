<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TouristVisitorDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tourist_visitor_details';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'location_id',
        'date',
        'reporting_time',
        'men',
        'women',
        'children',
        'foreign_men',
        'foreign_women',
        'foreign_children',
        'no_of_pilgrims',
        'no_of_vehicles',
        'dead_due_health',
        'dead_due_nature',
        'dead_today',
        'missing_due_health',
        'missing_due_nature',
        'missing_today',
        'pilgrims_till_date',
        'vehicles_till_date',
        'dead_till_date',
        'missing_till_date',
        'entry_date',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'date' => 'date',
        'reporting_time' => 'datetime:H:i',
        'entry_date' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * Relationships
     */

    // 🔹 Each visitor detail belongs to a specific Dham (location)
    public function dham()
    {
        return $this->belongsTo(Dham::class, 'location_id');
    }

    /**
     * Accessors / Helpers (optional)
     */
    public function getTotalVisitorsAttribute()
    {
        return $this->men + $this->women + $this->children + 
               $this->foreign_men + $this->foreign_women + $this->foreign_children;
    }
}
