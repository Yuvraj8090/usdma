<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoadClosedFillable extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'road_closed_fillables';

    protected $fillable = [
        'parent_id',
        'name',
        'description',
        'is_active',
    ];

    /**
     * Parent relationship (self-referencing)
     */
    public function parent()
    {
        return $this->belongsTo(RoadClosedFillable::class, 'parent_id');
    }

    /**
     * Children relationship (self-referencing)
     */
    public function children()
    {
        return $this->hasMany(RoadClosedFillable::class, 'parent_id');
    }

    /**
     * Reports under this fillable
     */
    public function reports()
    {
        return $this->hasMany(RoadClosedReport::class, 'fillable_id');
    }
}
