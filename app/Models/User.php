<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * Mass assignable attributes
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
    ];

    /**
     * Hidden attributes
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * Attribute casting
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_service_date' => 'date',
        'password' => 'hashed',
    ];

    /**
     * Accessors appended to model
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /* ============================
     | Relationships
     |============================ */

    /**
     * User belongs to a Role
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * User belongs to many Districts
     */
    public function districts()
    {
        return $this->belongsToMany(District::class, 'district_user');
    }

    /* ============================
     | Helpers
     |============================ */

    /**
     * Check if user is Admin
     */
    public function isAdmin(): bool
    {
        return $this->role?->name === 'Admin';
    }
}
