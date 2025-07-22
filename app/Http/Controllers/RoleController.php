<?php

namespace App\Http\Controllers;
use App\Models\Role;

use Illuminate\Http\Request;

class RoleController extends Controller
{
    //
    public function index()
    {
        return Role::all();
    }
    // Store a new role
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50|unique:roles',
            'view_tickets' => 'required|boolean',
            'edit_tickets' => 'required|boolean',
            'delete_tickets' => 'required|boolean',
            'assign_tickets' => 'required|boolean',
        ]);

        $role = Role::create($request->all());

        return response()->json(['message' => 'Role created successfully', 'data' => $role], 201);
    }
    // Show a specific role
    public function show($id)
    {
        $role = Role::find($id);

        if (!$role) {
            return response()->json(['message' => 'Role not found'], 404);
        }

        return response()->json($role);
    }
    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $role->update($request->all());

        return response()->json($role);
    }

    public function destroy($id)
    {
        Role::findOrFail($id)->delete();

        return response()->json(['message' => 'Role deleted']);
    }
}
