<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Meeting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MeetingController extends Controller
{
    /**
     * Display a listing of all meetings.
     * 
     * Retrieves all meetings in descending order of creation.
     * No pagination applied.
     */
    public function index()
    {
        $meetings = Meeting::latest()->get(); // Get all meetings sorted by newest first
        return view('admin.meetings.index', compact('meetings'));
    }

    /**
     * Show the form for creating a new meeting.
     */
    public function create()
    {
        return view('admin.meetings.create');
    }

    /**
     * Store a newly created meeting in storage.
     *
     * Validates the request, handles optional file upload, and saves the meeting.
     */
    public function store(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'date'             => 'required|date',
            'time'             => 'required',
            'meeting_location' => 'required|string|max:255',
            'topic'            => 'required|string|max:255',
            'abhiyoukti'       => 'nullable|string',
            'file_url'         => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
            'meeting_url'      => 'nullable|url',
        ]);

        // Collect validated data
        $data = $request->only(['date', 'time', 'meeting_location', 'topic', 'abhiyoukti', 'meeting_url']);

        // Handle file upload if provided
        if ($request->hasFile('file_url')) {
            $data['file_url'] = $request->file('file_url')->store('meetings_files', 'public');
        }

        // Create the meeting record
        Meeting::create($data);

        // Redirect back with success message
        return redirect()->route('admin.meetings.index')
                         ->with('success', 'Meeting created successfully.');
    }

    /**
     * Show the form for editing the specified meeting.
     */
    public function edit(Meeting $meeting)
    {
        return view('admin.meetings.edit', compact('meeting'));
    }

    /**
     * Update the specified meeting in storage.
     *
     * Validates the request, handles optional file upload replacement, and updates the meeting.
     */
    public function update(Request $request, Meeting $meeting)
    {
        // Validate incoming request
        $request->validate([
            'date'             => 'required|date',
            'time'             => 'required',
            'meeting_location' => 'required|string|max:255',
            'topic'            => 'required|string|max:255',
            'abhiyoukti'       => 'nullable|string',
            'file_url'         => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
            'meeting_url'      => 'nullable|url',
        ]);

        // Collect validated data
        $data = $request->only(['date', 'time', 'meeting_location', 'topic', 'abhiyoukti', 'meeting_url']);

        // Handle file upload
        if ($request->hasFile('file_url')) {
            // Delete old file if it exists
            if ($meeting->file_url && Storage::disk('public')->exists($meeting->file_url)) {
                Storage::disk('public')->delete($meeting->file_url);
            }

            // Store new file
            $data['file_url'] = $request->file('file_url')->store('meetings_files', 'public');
        }

        // Update the meeting record
        $meeting->update($data);

        // Redirect back with success message
        return redirect()->route('admin.meetings.index')
                         ->with('success', 'Meeting updated successfully.');
    }

    /**
     * Remove the specified meeting from storage (soft delete).
     *
     * Uses the soft delete feature of the Meeting model.
     */
    public function destroy(Meeting $meeting)
    {
        $meeting->delete(); // Soft delete

        return redirect()->route('admin.meetings.index')
                         ->with('success', 'Meeting deleted successfully.');
    }
}
