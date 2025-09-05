<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DistrictUser extends Model
{
    use HasFactory;

    protected $table = 'district_user'; // pivot table

    protected $fillable = [
        'user_id',
        'district_id',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    /**
     * Apply global scope based on user role.
     */
    protected static function booted()
    {
        if (auth()->check() && auth()->user()->role_id != 1) {
            static::addGlobalScope('user', function ($query) {
                $query->where('user_id', auth()->id());
            });
        }
    }
}
