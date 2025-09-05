<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DistrictUser;
use App\Models\User;
use App\Models\District;
use Illuminate\Http\Request;

class DistrictUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $assignments = DistrictUser::with(['user', 'district'])->latest()->paginate(10);

        return view('admin.district_users.index', compact('assignments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        $districts = District::all();

        return view('admin.district_users.create', compact('users', 'districts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validated = $request->validate([
        'user_id' => 'required|array',
        'user_id.*' => 'exists:users,id',
        'district_id' => 'required|exists:districts,id',
    ]);

    foreach ($validated['user_id'] as $userId) {
        DistrictUser::create([
            'user_id' => $userId,
            'district_id' => $validated['district_id'],
        ]);
    }

    return redirect()->route('admin.district-users.index')
        ->with('success', 'District assigned successfully to selected users.');
}


    /**
     * Display the specified resource.
     */
    public function show(DistrictUser $districtUser)
    {
        return view('admin.district_users.show', compact('districtUser'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DistrictUser $districtUser)
{
    $users = User::all();
    $districts = District::all();

    // get all users assigned to this district
    $assignedUserIds = DistrictUser::where('district_id', $districtUser->district_id)->pluck('user_id')->toArray();

    return view('admin.district_users.edit', compact('districtUser', 'users', 'districts', 'assignedUserIds'));
}


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DistrictUser $districtUser)
{
    $validated = $request->validate([
        'user_id' => 'required|array',
        'user_id.*' => 'exists:users,id',
        'district_id' => 'required|exists:districts,id',
    ]);

    // delete old assignments for this district
    DistrictUser::where('district_id', $districtUser->district_id)->delete();

    // insert new ones
    foreach ($validated['user_id'] as $userId) {
        DistrictUser::create([
            'user_id' => $userId,
            'district_id' => $validated['district_id'],
        ]);
    }

    return redirect()->route('admin.district-users.index')
        ->with('success', 'District assignment updated successfully.');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DistrictUser $districtUser)
    {
        $districtUser->delete();

        return redirect()->route('admin.district-users.index')
            ->with('success', 'District assignment deleted successfully.');
    }
}
