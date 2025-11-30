<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyType extends Model
{
    protected $fillable = ['name'];

    public function propertyLosses()
    {
        return $this->hasMany(PropertyLoss::class);
    }
}
