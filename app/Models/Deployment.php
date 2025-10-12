<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Deployment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'deployable_id',
        'deployable_type',
        'district_id',
        'location',
        'deployed_at',
        'returned_at',
        'remarks',
    ];

    protected $casts = [
        'deployed_at' => 'datetime',
        'returned_at' => 'datetime',
    ];

    public function district() {
        return $this->belongsTo(District::class);
    }

    public function deployable() {
        return $this->morphTo();
    }
}
