<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        return response()->json(Employee::all(), 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email',
            'username' => 'required|string|max:255|unique:employees,username',
            'personnel_no' => 'required|string|max:255',
            'position_id' => 'required|exists:positions,id',
        ]);

        $employee = Employee::create($validatedData);

        return response()->json($employee, 201);
    }

    public function show(Employee $employee)
    {
        return response()->json($employee, 200);
    }

    public function update(Request $request, Employee $employee)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,' . $employee->id,
            'username' => 'required|string|max:255|unique:employees,username,' . $employee->id,
            'personnel_no' => 'required|string|max:255',
            'position_id' => 'required|exists:positions,id',
        ]);

        $employee->update($validatedData);

        return response()->json($employee, 200);
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();

        return response()->json(null, 204);
    }
}
