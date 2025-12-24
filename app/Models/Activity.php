<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'activity_name',
    ];

    public function equipments()
    {
        return $this->hasMany(Equipment::class);
    }
}
