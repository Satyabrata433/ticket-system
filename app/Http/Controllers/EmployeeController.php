<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        return Employee::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:employees,email',
            'mobile_number' => 'required|string|max:15',
            'address' => 'required|string',
            'role_id' => 'required|exists:roles,id',
        ]);

        $employee = Employee::create($validated);
        return response()->json($employee, 201);
    }

    public function show($id)
    {
        $employee = Employee::findOrFail($id);
        return response()->json($employee);
    }

    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:100',
            'email' => 'sometimes|required|email|unique:employees,email,' . $id,
            'mobile_number' => 'sometimes|required|string|max:15',
            'address' => 'sometimes|required|string',
            'role_id' => 'sometimes|required|exists:roles,id',
        ]);

        $employee->update($validated);
        return response()->json($employee);
    }

    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();
        return response()->json(['message' => 'Employee deleted successfully']);
    }
}
