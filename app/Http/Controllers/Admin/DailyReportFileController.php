<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DailyReportFile;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DailyReportFileController extends Controller
{
    // Show calendar events
    public function index()
    {
        $files = DailyReportFile::all();

        $events = $files->map(function ($file) {
            return [
                'title' => $file->report_type == 1 ? 'Morning' : 'Evening',
                'start' => $file->submit_date->format('Y-m-d'),
                'url'   => asset('storage/' . $file->file_path),

                // COLORS
                'color' => $file->report_type == 1 ? '#2563eb' : '#f97316',

                // sorting
                'report_type' => $file->report_type,
            ];
        });

        return view('admin.daily_report_files.index', compact('events'));
    }


    // Store Report File
    public function store(Request $request)
    {
        $request->validate([
            'file'        => 'required|file|mimes:pdf,doc,docx,xlsx,jpg,png',
            'submit_date' => 'required|date',
            'report_type' => 'required|integer|in:1,2', // 1 = Morning, 2 = Evening
        ]);

        // Store file
        $path = $request->file('file')->store('daily_reports', 'public');

        // Auto take current time
        $currentTime = now()->format('H:i:s'); // server time

        // Combine user date + auto time
        $submitDateTime = Carbon::parse($request->submit_date . ' ' . $currentTime);

        // Save record
        DailyReportFile::create([
            'file_path'   => $path,
            'submit_date' => $submitDateTime,
            'report_type' => $request->report_type,
        ]);

        return back()->with('success', 'Report uploaded successfully with auto time!');
    }
}
