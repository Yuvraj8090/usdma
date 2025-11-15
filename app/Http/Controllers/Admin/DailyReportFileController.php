<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DailyReportFile;
use Illuminate\Http\Request;

class DailyReportFileController extends Controller
{
    public function index()
    {
        $files = DailyReportFile::all();

        // Convert to events for calendar
        $events = $files->map(function ($file) {
            return [
                'title' => basename($file->file_path),
                'start' => $file->submit_date->format('Y-m-d H:i:s'),
                'url'   => asset('storage/' . $file->file_path),
            ];
        });

        return view('admin.daily_report_files.index', compact('events'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'file'        => 'required|file|mimes:pdf,doc,docx,xlsx,jpg,png',
            'submit_date' => 'required|date',
            'submit_time' => 'required',
            'report_type' => 'required|integer|in:1,2', // 1 = Morning, 2 = Evening
        ]);

        // Store file
        $path = $request->file('file')->store('daily_reports', 'public');

        // Combine date + time
        $submitDateTime = $request->submit_date . ' ' . $request->submit_time;

        // Create record
        DailyReportFile::create([
            'file_path'   => $path,
            'submit_date' => $submitDateTime,
            'report_type' => $request->report_type, // store morning/evening
        ]);

        return back()->with('success', 'Report uploaded successfully!');
    }
}
