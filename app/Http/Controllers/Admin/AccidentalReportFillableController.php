<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccidentalReportFillable;
use Illuminate\Http\Request;

class AccidentalReportFillableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = AccidentalReportFillable::query()->with('children');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $fillables = $query->paginate(15);

        return view('admin.accidental_reports_fillable.index', compact('fillables'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parents = AccidentalReportFillable::whereNull('parent_id')->get();
        return view('admin.accidental_reports_fillable.create', compact('parents'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_id'   => 'nullable|exists:accidental_reports_fillable,id',
            'is_active'   => 'boolean',
        ]);

        AccidentalReportFillable::create($request->only('name', 'description', 'parent_id', 'is_active'));

        return redirect()->route('admin.accidental-reports-fillable.index')
                         ->with('success', 'Accidental report category created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AccidentalReportFillable $accidentalReportsFillable)
    {
        $parents = AccidentalReportFillable::whereNull('parent_id')
                                           ->where('id', '!=', $accidentalReportsFillable->id)
                                           ->get();

        return view('admin.accidental_reports_fillable.edit', compact('accidentalReportsFillable', 'parents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AccidentalReportFillable $accidentalReportsFillable)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_id'   => 'nullable|exists:accidental_reports_fillable,id',
            'is_active'   => 'boolean',
        ]);

        $accidentalReportsFillable->update($request->only('name', 'description', 'parent_id', 'is_active'));

        return redirect()->route('admin.accidental-reports-fillable.index')
                         ->with('success', 'Accidental report category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AccidentalReportFillable $accidentalReportsFillable)
    {
        $accidentalReportsFillable->delete();

        return redirect()->route('admin.accidental-reports-fillable.index')
                         ->with('success', 'Accidental report category deleted successfully.');
    }
}
