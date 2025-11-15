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
        'report_type', // 1 = Morning, 2 = Evening
    ];

    protected $casts = [
        'submit_date' => 'date', // or 'datetime'
        'report_type' => 'integer',
    ];
}
