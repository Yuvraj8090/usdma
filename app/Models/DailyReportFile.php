<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DailyReportFile extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'file_path',
        'submit_date',
    ];

    // 🔹 Cast submit_date to Carbon instance
    protected $casts = [
        'submit_date' => 'datetime',
    ];
}
