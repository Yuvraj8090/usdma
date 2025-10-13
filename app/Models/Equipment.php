<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Equipment extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'equipments';

    protected $fillable = ['name', 'type', 'district_id', 'quantity', 'remarks', 'is_active'];

    public function district()
    {
        return $this->belongsTo(District::class);
    }
    public function category()
    {
        return $this->belongsTo(EquipmentCategory::class, 'category_id');
    }
}
