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
            'file' => 'required|file|mimes:pdf,doc,docx,xlsx,jpg,png',
            'submit_date' => 'required|date',
            'submit_time' => 'required',
        ]);

        $path = $request->file('file')->store('daily_reports', 'public');

        DailyReportFile::create([
            'file_path'   => $path,
            'submit_date' => $request->submit_date . ' ' . $request->submit_time,
        ]);

        return back()->with('success', 'Report uploaded successfully!');
    }
}
