<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NaturalDisasterReportsFillable extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'natural_disaster_reports_fillable';

    protected $fillable = [
        'parent_id',
        'name',
        'description',
        'is_active',
    ];

    /**
     * Relationship: Get the parent disaster report.
     */
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * Relationship: Get the child disaster reports.
     */
    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    /**
     * Scope: Only active records.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
