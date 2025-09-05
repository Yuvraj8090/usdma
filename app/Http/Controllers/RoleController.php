<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    // Display all roles
    public function index()
{
    // Fetch 10 roles per page
    $roles = Role::orderBy('created_at', 'desc')->paginate(10);
    
    return view('roles.index', compact('roles'));
}


    // Show form to create a role
    public function create()
    {
        return view('roles.create');
    }

    // Store new role
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'description' => 'nullable|string',
        ]);

        Role::create($request->all());

        return redirect()->route('admin.roles.index')->with('success', 'Role created successfully.');
    }

    // Show single role
    public function show(Role $role)
    {
        return view('roles.show', compact('role'));
    }

    // Show form to edit role
    public function edit(Role $role)
    {
        return view('roles.edit', compact('role'));
    }

    // Update role
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'description' => 'nullable|string',
        ]);

        $role->update($request->all());

        return redirect()->route('admin.roles.index')->with('success', 'Role updated successfully.');
    }

    // Delete role
    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('admin.roles.index')->with('success', 'Role deleted successfully.');
    }
}
