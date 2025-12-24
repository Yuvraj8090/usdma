<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DailyReportsFillable;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DailyReportsFillableController extends Controller
{
    

public function index(Request $request)
{
    if ($request->ajax()) {
        $query = DailyReportsFillable::with('parent');

        return DataTables::of($query)
            ->addColumn('parent_name', function ($row) {
                return $row->parent?->name ?? '-';
            })
            ->addColumn('status', function ($row) {
                return $row->is_active
                    ? '<span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded">Active</span>'
                    : '<span class="px-2 py-1 text-xs bg-red-100 text-red-800 rounded">Inactive</span>';
            })
            ->addColumn('actions', function ($row) {
                return '
                    <a href="'.route('admin.daily_reports_fillable.edit', $row->id).'"
                        class="px-3 py-1 bg-yellow-500 text-white rounded-lg shadow hover:bg-yellow-600">
                        <i class="fas fa-edit"></i>
                    </a>

                    <form action="'.route('admin.daily_reports_fillable.destroy', $row->id).'"
                        method="POST" class="inline">
                        '.csrf_field().method_field('DELETE').'
                        <button onclick="return confirm(\'Delete this category?\')"
                            class="px-3 py-1 bg-red-600 text-white rounded-lg shadow hover:bg-red-700">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                ';
            })
            ->rawColumns(['status', 'actions'])
            ->make(true);
    }

    return view('admin.daily_reports_fillable.index');
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
