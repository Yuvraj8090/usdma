<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NavbarItem extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'navbar_items';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'slug',
        'parent_id',
        'is_dropdown',
        'order',
        'is_active',
        'route',
        'url',
        'icon',
    ];

    /**
     * Parent relationship (if item belongs to a dropdown).
     */
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * Children relationship (dropdown sub-items).
     */
    public function children()
    {
        return $this->hasMany(self::class, 'parent_id')
            ->orderBy('order');
    }

    /**
     * Scope for active items.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get route or URL to navigate.
     */
    public function getLinkAttribute()
    {
        if ($this->route) {
            return route($this->route);
        }

        return $this->url ?? '#';
    }
}
