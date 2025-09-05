<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DailyReport extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'daily_reports';

    protected $fillable = [
        'district_id',
        'fillable_id',
        'count',
        'report_date',
    ];
protected $casts = [
    'report_date' => 'date',
];

    // Relationships
    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function fillableCategory()
    {
        return $this->belongsTo(DailyReportsFillable::class, 'fillable_id');
    }
}
