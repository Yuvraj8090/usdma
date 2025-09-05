<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DistrictReport extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'district_id',
        'body',
        'submit_date',
    ];

    protected $casts = [
        'submit_date' => 'date',
    ];

    public function district()
    {
        return $this->belongsTo(District::class);
    }
}
