<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DailyReportDham extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'daily_reports_dhams';

    protected $fillable = [
        'dham_id', 'fillable_id', 'count', 'report_date', 
    ];

    protected $casts = [
        'report_date' => 'date',
        
        'count'       => 'integer',
    ];

    public function dham()
    {
        return $this->belongsTo(Dham::class, 'dham_id');
    }

    public function fillableCategory()
    {
        return $this->belongsTo(DailyReportsFillable::class, 'fillable_id');
    }
}
