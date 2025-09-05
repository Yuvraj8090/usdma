<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MediaFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaFileController extends Controller
{
    public function index()
    {
        $mediaFiles = MediaFile::latest()->paginate(10);
        return view('admin.media_files.index', compact('mediaFiles'));
    }

    public function create()
    {
        return view('admin.media_files.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:10240', // max 10MB
        ]);

        $file = $request->file('file');
        $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $filePath = $file->storeAs('media_files', $fileName, 'public');

        MediaFile::create([
            'name' => $file->getClientOriginalName(),
            'file_name' => $fileName,
            'file_path' => $filePath,
            'mime_type' => $file->getClientMimeType(),
            'size' => $file->getSize(),
        ]);

        return redirect()->route('admin.media-files.index')
                         ->with('success', 'File uploaded successfully.');
    }

    public function show(MediaFile $mediaFile)
    {
        return view('admin.media_files.show', compact('mediaFile'));
    }

    public function edit(MediaFile $mediaFile)
    {
        return view('admin.media_files.edit', compact('mediaFile'));
    }

    public function update(Request $request, MediaFile $mediaFile)
    {
        $request->validate([
            'file' => 'nullable|file|max:10240',
        ]);

        if ($request->hasFile('file')) {
            // Delete old file
            if (Storage::disk('public')->exists($mediaFile->file_path)) {
                Storage::disk('public')->delete($mediaFile->file_path);
            }

            $file = $request->file('file');
            $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('media_files', $fileName, 'public');

            $mediaFile->update([
                'name' => $file->getClientOriginalName(),
                'file_name' => $fileName,
                'file_path' => $filePath,
                'mime_type' => $file->getClientMimeType(),
                'size' => $file->getSize(),
            ]);
        }

        return redirect()->route('admin.media-files.index')
                         ->with('success', 'File updated successfully.');
    }

    public function destroy(MediaFile $mediaFile)
    {
        // Delete from storage
        if (Storage::disk('public')->exists($mediaFile->file_path)) {
            Storage::disk('public')->delete($mediaFile->file_path);
        }

        $mediaFile->delete();

        return redirect()->route('admin.media-files.index')
                         ->with('success', 'File deleted successfully.');
    }

    public function download(MediaFile $mediaFile)
    {
        return Storage::disk('public')->download($mediaFile->file_path, $mediaFile->name);
    }
}
