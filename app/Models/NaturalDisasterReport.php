<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NaturalDisasterReport extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'natural_disaster_reports';

    protected $fillable = [
        'district_id',
        'fillable_id',
        'count',
        'report_date',
    ];

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    public function fillableCategory()
    {
        return $this->belongsTo(NaturalDisasterReportsFillable::class, 'fillable_id');
    }
}
