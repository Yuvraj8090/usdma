<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Village extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'tehsil_id',
        'district_id',
        'is_active',
    ];

    /**
     * 🔗 Relationship: Village belongs to Tehsil
     */
    public function tehsil()
    {
        return $this->belongsTo(Tehsil::class);
    }

    /**
     * 🔗 Relationship: Village belongs to District
     */
    public function district()
    {
        return $this->belongsTo(District::class);
    }
}
