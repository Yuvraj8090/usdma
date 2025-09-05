<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class District extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'districts';

    protected $fillable = [
        'name',
        'state_id',
        'is_active',
    ];
public function users()
{
    return $this->belongsToMany(User::class, 'district_user');
}

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relationship
    public function state()
    {
        return $this->belongsTo(State::class);
    }
}
