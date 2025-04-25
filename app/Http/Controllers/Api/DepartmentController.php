<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Department::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => [
                'required',
                'string',
                'unique:departments,name', // Ensure name is unique in the departments table
            ],
        ], [
            'name.unique' => 'The department name has already been taken. Please choose a different name.' // Custom error message
        ]);
    
        Department::create($data);
    
        return response()->json([
            'status' => true,
            'message' => 'Department Created Successfully'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        return response()->json([
            'status' => 'true',
            'message' => 'Department Found',
            'data' => $department
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Department $department)
    {
        $request->validate([
            'name' => [
                'required', // Make the name field required
                'string',
                'unique:departments,name,' . $department->id // Ensure name is unique, ignoring the current department
            ],
        ], [
            'name.required' => 'The department name is required.', // Custom error message for required field
            'name.unique' => 'The department name has already been taken. Please choose a different name.' // Custom error message for uniqueness
        ]);
    
        // Update the department with the validated data
        $department->update($request->all());
    
        return response()->json([
            'status' => true,
            'message' => 'Department updated successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        $department->delete();

        return response()->json([
            'status' => true,
            'message' => 'Department Deleted Successfully'
        ]);
    }
}
