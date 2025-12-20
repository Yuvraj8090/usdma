<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dham;
use App\Models\State;
use App\Models\District;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
class DhamController extends Controller
{



public function index(Request $request)
{
    if ($request->ajax()) {
        $dhams = Dham::select(['id', 'name', 'latitude', 'longitude', 'height', 'is_winter']);

        return DataTables::of($dhams)
            ->addColumn('is_winter_text', function($row) {
                return $row->is_winter ? 'Yes' : 'No';
            })
            ->addColumn('actions', function($row) {
                $editUrl = route('admin.dhams.edit', $row->id);
                $deleteUrl = route('admin.dhams.destroy', $row->id);
                return '
                    <a href="'.$editUrl.'" class="inline-flex items-center px-3 py-1 bg-gradient-to-r from-yellow-400 to-yellow-500 border border-transparent rounded-lg font-medium text-white hover:from-yellow-500 hover:to-yellow-600 transition-all duration-200 shadow mr-1">
                        <i class="fas fa-edit mr-1 text-xs"></i> Edit
                    </a>
                    <form action="'.$deleteUrl.'" method="POST" class="inline">
                        '.csrf_field().method_field('DELETE').'
                        <button type="submit" onclick="return confirm(\'Are you sure?\')" class="inline-flex items-center px-3 py-1 bg-gradient-to-r from-red-500 to-red-600 border border-transparent rounded-lg font-medium text-white hover:from-red-600 hover:to-red-700 transition-all duration-200 shadow">
                            <i class="fas fa-trash mr-1 text-xs"></i> Delete
                        </button>
                    </form>
                ';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    return view('admin.dhams.index');
}


    public function create()
    {
        $states = State::where('is_active', true)->get();
        $districts = District::where('is_active', true)->get();

        return view('admin.dhams.create', compact('states', 'districts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'state_id'    => 'required|exists:states,id',
            'district_id' => 'required|exists:districts,id',
            'latitude'    => 'nullable|numeric',
            'longitude'   => 'nullable|numeric',
            'height'      => 'nullable|integer',
            'is_active'   => 'boolean',
            'is_winter'   => 'boolean',
        ]);

        Dham::create($validated);

        return redirect()->route('admin.dhams.index')->with('success', 'Dham created successfully.');
    }

    public function edit(Dham $dham)
    {
        $states = State::where('is_active', true)->get();
        $districts = District::where('is_active', true)->get();

        return view('admin.dhams.edit', compact('dham', 'states', 'districts'));
    }

    public function update(Request $request, Dham $dham)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'state_id'    => 'required|exists:states,id',
            'district_id' => 'required|exists:districts,id',
            'latitude'    => 'nullable|numeric',
            'longitude'   => 'nullable|numeric',
            'height'      => 'nullable|integer',
            'is_active'   => 'boolean',
            'is_winter'   => 'boolean',
        ]);

        $dham->update($validated);

        return redirect()->route('admin.dhams.index')->with('success', 'Dham updated successfully.');
    }

    public function destroy(Dham $dham)
    {
        $dham->delete();

        return redirect()->route('admin.dhams.index')->with('success', 'Dham deleted successfully.');
    }
}
