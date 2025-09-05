<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dham extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dhams';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'state_id',
        'district_id',
        'is_active',
        'is_winter',
        'latitude',
        'longitude',
        'height',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'is_active' => 'boolean',
        'is_winter' => 'boolean',
        'latitude'  => 'decimal:7',
        'longitude' => 'decimal:7',
        'height'    => 'integer',
    ];

    /**
     * Relationships
     */
    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }
}
