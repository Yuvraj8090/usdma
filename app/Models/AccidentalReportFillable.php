<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccidentalReportFillable extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     */
    protected $table = 'accidental_reports_fillable';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'parent_id',
        'name',
        'description',
        'is_active',
    ];

    /**
     * Casts
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Relationships
     */

    // Parent category
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    // Child categories
    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    // Reports linked to this fillable category
    public function reports()
    {
        return $this->hasMany(AccidentalReport::class, 'fillable_id');
    }
}
