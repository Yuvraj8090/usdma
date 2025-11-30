<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nominee extends Model
{
    protected $fillable = [
        'incident_id',
        'name',
        'relation',
        'address',
    ];

    public function incident()
    {
        return $this->belongsTo(Incident::class);
    }
}
