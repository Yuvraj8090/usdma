<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DailyReportsFillable;
use Illuminate\Http\Request;

class DailyReportsFillableController extends Controller
{
    public function index(Request $request)
    {
        $query = DailyReportsFillable::query()->with('children');

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $fillables = $query->paginate(15);

        return view('admin.daily_reports_fillable.index', compact('fillables'));
    }

    public function create()
    {
        $parents = DailyReportsFillable::whereNull('parent_id')->get();
        return view('admin.daily_reports_fillable.create', compact('parents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'parent_id' => 'nullable|exists:daily_reports_fillable,id',
            'is_active' => 'boolean',
        ]);

        DailyReportsFillable::create($request->only('name', 'parent_id', 'is_active'));

        return redirect()->route('admin.daily_reports_fillable.index')
                         ->with('success', 'Category created successfully.');
    }

    public function edit(DailyReportsFillable $dailyReportsFillable)
    {
        $parents = DailyReportsFillable::whereNull('parent_id')->get();
        return view('admin.daily_reports_fillable.edit', compact('dailyReportsFillable', 'parents'));
    }

    public function update(Request $request, DailyReportsFillable $dailyReportsFillable)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'parent_id' => 'nullable|exists:daily_reports_fillable,id',
            'is_active' => 'boolean',
        ]);

        $dailyReportsFillable->update($request->only('name', 'parent_id', 'is_active'));

        return redirect()->route('admin.daily_reports_fillable.index')
                         ->with('success', 'Category updated successfully.');
    }

    public function destroy(DailyReportsFillable $dailyReportsFillable)
    {
        $dailyReportsFillable->delete();
        return redirect()->route('admin.daily_reports_fillable.index')
                         ->with('success', 'Category deleted successfully.');
    }
}
