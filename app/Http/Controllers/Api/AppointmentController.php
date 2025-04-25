<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Department;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $appointments = Appointment::with(['department', 'doctor', 'user', 'location'])->get();
        return response()->json($appointments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'location_id' => 'required|exists:locations,id',
                'department_id' => 'required|exists:departments,id',
                'doctor_id' => 'required|exists:doctors,id',
                'subject' => 'required|string|max:255',
                'prescription' => 'nullable|string',
                'time_slot' => 'required|string',
            ]);

            // Check if user is authenticated
            if (!Auth::check()) {
                return response()->json(['error' => 'User  not authenticated'], 401);
            }

            // Create the appointment and associate it with the authenticated user
            $appointment = Appointment::create([
                'user_id' => Auth::id(),
                'location_id' => $request->location_id,
                'department_id' => $request->department_id,
                'doctor_id' => $request->doctor_id,
                'subject' => $request->subject,
                'prescription' => $request->prescription,
                'time_slot' => $request->time_slot,
            ]);

            return response()->json($appointment, 201);
        } catch (\Exception $e) {
            // Log the error message
            \Log::error('Error creating appointment: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while creating the appointment.'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment)
    {
        // Load the associated department, doctor, user, and location for the specified appointment
        return response()->json($appointment->load(['department', 'doctor', 'user', 'location']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appointment $appointment)
    {
        $request->validate([
            'location_id' => 'sometimes|required|exists:locations,id', // Validate location_id
            'department_id' => 'sometimes|required|exists:departments,id',
            'doctor_id' => 'sometimes|required|exists:doctors,id',
            'subject' => 'sometimes|required|string|max:255',
            'prescription' => 'nullable|string',
            'time_slot' => 'sometimes|required|string',
        ]);

        // Prepare the data to update
        $dataToUpdate = [];

        // Only update fields that are present in the request
        if ($request->has('location_id')) {
            $dataToUpdate['location_id'] = $request->location_id;
        }
        if ($request->has('department_id')) {
            $dataToUpdate['department_id'] = $request->department_id;
        }
        if ($request->has('doctor_id')) {
            $dataToUpdate['doctor_id'] = $request->doctor_id;
        }
        if ($request->has('subject')) {
            $dataToUpdate['subject'] = $request->subject;
        }
        if ($request->has('prescription')) {
            $dataToUpdate['prescription'] = $request->prescription;
        }
        if ($request->has('time_slot')) {
            $dataToUpdate['time_slot'] = $request->time_slot;
        }

        // Update the appointment with the new data
        $appointment->update($dataToUpdate);

        return response()->json($appointment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return response()->json(['message' => 'Appointment has been deleted successfully.'], 200); // Return a 200 OK response with a message
    }

    /**
     * Get departments and doctors based on the selected location.
     */
    public function getDepartmentsAndDoctors(Request $request)
    {
        $request->validate([
            'location_id' => 'required|exists:locations,id',
        ]);

        // Get departments related to the location
        $departments = Department::where('location_id', $request->location_id)->get();

        // Get doctors related to the location
        $doctors = Doctor::where('location_id', $request->location_id)->get();

        return response()->json([
            'departments' => $departments,
            'doctors' => $doctors,
        ]);
    }
}