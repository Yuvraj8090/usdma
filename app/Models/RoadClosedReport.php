<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoadClosedReport extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'road_closed_reports';

    protected $fillable = [
        'district_id',
        'fillable_id',
        'data',
        'report_date',
    ];

    /**
     * Belongs to fillable (the field definition)
     */
    public function fillableItem()
    {
        return $this->belongsTo(RoadClosedFillable::class, 'fillable_id');
    }

    /**
     * Belongs to district (optional)
     */
    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }
}
