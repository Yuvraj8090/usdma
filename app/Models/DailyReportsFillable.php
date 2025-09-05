<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DailyReportsFillable extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'daily_reports_fillable';

    protected $fillable = [
        'parent_id',
        'name',
        'is_active',
    ];

    // Self-referencing relationship
    public function parent()
    {
        return $this->belongsTo(DailyReportsFillable::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(DailyReportsFillable::class, 'parent_id');
    }
}
