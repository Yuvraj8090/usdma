<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tehsil extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'district_id',
        'is_active',
    ];

    public function district()
    {
        return $this->belongsTo(District::class);
    }
}
