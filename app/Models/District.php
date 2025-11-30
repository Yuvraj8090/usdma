<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class District extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'districts';

    protected $fillable = ['name', 'state_id', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relationships
    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'district_user');
    }

    // Apply global scope to filter districts based on assigned user
    protected static function booted()
    {
        static::addGlobalScope('assignedDistricts', function (Builder $query) {
            if (auth()->check() && auth()->user()->role_id != 1) {
                $query->whereHas('users', function ($q) {
                    $q->where('user_id', auth()->id());
                });
            }
        });
    }
}
