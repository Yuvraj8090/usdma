<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Activity::query())
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('admin.activities.actions', compact('row'));
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.activities.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'activity_name' => 'required|string|max:255',
        ]);

        Activity::create($request->only('activity_name'));

        return response()->json(['success' => 'Activity created successfully']);
    }

    public function edit(Activity $activity)
    {
        return response()->json($activity);
    }

    public function update(Request $request, Activity $activity)
    {
        $request->validate([
            'activity_name' => 'required|string|max:255',
        ]);

        $activity->update($request->only('activity_name'));

        return response()->json(['success' => 'Activity updated successfully']);
    }

    public function destroy(Activity $activity)
    {
        $activity->delete();
        return response()->json(['success' => 'Activity deleted successfully']);
    }
}
