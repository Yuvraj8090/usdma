<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of users.
     */
   

public function index(Request $request)
{
    if ($request->ajax()) {
        $users = User::with('role')->select('users.*'); // Make sure to select users table columns

        return DataTables::of($users)
            ->addColumn('role', function($user) {
                return $user->role->name ?? '-';
            })
            ->addColumn('last_service_date', function($user) {
                return $user->last_service_date?->format('Y-m-d') ?? '-';
            })
            ->addColumn('actions', function($user) {
                $edit = '<a href="'.route('admin.users.edit', $user->id).'" class="inline-flex items-center px-3 py-1 bg-gradient-to-r from-yellow-400 to-yellow-500 rounded text-white shadow hover:from-yellow-500 hover:to-yellow-600 gap-1">
                            <i class="fas fa-edit text-xs"></i> Edit
                        </a>';
                $delete = '<form action="'.route('admin.users.destroy', $user->id).'" method="POST" class="inline ml-1">'
                        . csrf_field()
                        . method_field('DELETE')
                        . '<button type="submit" onclick="return confirm(\'Are you sure you want to delete this user?\')" class="inline-flex items-center px-3 py-1 bg-gradient-to-r from-red-500 to-red-600 rounded text-white shadow hover:from-red-600 hover:to-red-700 gap-1">
                            <i class="fas fa-trash text-xs"></i> Delete
                        </button>
                        </form>';
                return $edit . $delete;
            })
            ->rawColumns(['actions']) // Allow HTML in actions column
            ->make(true);
    }

    return view('admin.users.index');
}


    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
            'last_service_date' => 'nullable|date', // <--- nullable date validation
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
            'last_service_date' => $request->last_service_date ?: null, // <--- ensure null if empty
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
            'last_service_date' => 'nullable|date', // <--- nullable date validation
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
            'role_id' => $request->role_id,
            'last_service_date' => $request->last_service_date ?: null, // <--- handle null
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
}
