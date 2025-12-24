<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ResourceType;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ResourceTypeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(ResourceType::query())
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('admin.resource-types.actions', compact('row'));
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.resource-types.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'resource_type' => 'required|string|max:255',
        ]);

        ResourceType::create($request->only('resource_type'));

        return response()->json(['success' => 'Resource Type created']);
    }

    public function edit(ResourceType $resourceType)
    {
        return response()->json($resourceType);
    }

    public function update(Request $request, ResourceType $resourceType)
    {
        $request->validate([
            'resource_type' => 'required|string|max:255',
        ]);

        $resourceType->update($request->only('resource_type'));

        return response()->json(['success' => 'Resource Type updated']);
    }

    public function destroy(ResourceType $resourceType)
    {
        $resourceType->delete();
        return response()->json(['success' => 'Resource Type deleted']);
    }
}
