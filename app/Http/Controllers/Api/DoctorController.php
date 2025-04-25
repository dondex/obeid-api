<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Doctor::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255', // Doctor's name
            'department_id' => 'required|exists:departments,id', // Validate department ID
            'doctor_image' => 'nullable|string|max:255', // Doctor's image (optional)
            'available_time_slot' => 'required|string|max:255', // Available time slot
        ]);
    
        // Create a new Doctor instance
        $doctor = Doctor::create([
            'name' => $request->name,
            'department_id' => $request->department_id,
            'doctor_image' => $request->doctor_image,
            'available_time_slot' => $request->available_time_slot,
        ]);
    
        // Return a response indicating success
        return response()->json([
            'status' => true,
            'message' => 'Doctor created successfully',
            'data' => $doctor,
        ], 201); // 201 Created status code
    }

    /**
     * Display the specified resource.
     */
    public function show(Doctor $doctor)
    {
        return response()->json([
            'status' => true,
            'data' => $doctor,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Doctor $doctor)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'sometimes|required|string|max:255', // Doctor's name
            'department_id' => 'sometimes|required|exists:departments,id', // Validate department ID
            'doctor_image' => 'sometimes|nullable|string|max:255', // Doctor's image (optional)
            'available_time_slot' => 'sometimes|required|string|max:255', // Available time slot
        ]);

        // Update the Doctor instance
        $doctor->update($request->only(['name', 'department_id', 'doctor_image', 'available_time_slot']));

        return response()->json([
            'status' => true,
            'message' => 'Doctor updated successfully',
            'data' => $doctor,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Doctor $doctor)
    {
        $doctor->delete();

        return response()->json([
            'status' => true,
            'message' => 'Doctor deleted successfully',
        ]);
    }
}
