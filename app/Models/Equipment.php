<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Equipment extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'equipments';

    protected $fillable = [
        'name', 
        'code', 
        'category_id',  // Fixed: Added category_id
        'district_id', 
        'quantity', 
        'remarks', 
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'quantity' => 'integer'
    ];

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }
    
    public function category()
    {
        return $this->belongsTo(EquipmentCategory::class, 'category_id');
    }
}