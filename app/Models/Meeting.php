<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Meeting extends Model
{
    use HasFactory, SoftDeletes;

    // Mass assignable fields
    protected $fillable = [
        'date',
        'time',
        'meeting_location',
        'topic',
        'abhiyoukti',
        'file_url',
        'meeting_url',
    ];

    // Casts for proper date and time formatting
    protected $casts = [
        'date' => 'date:Y-m-d',
        'time' => 'datetime:H:i',
    ];
}
