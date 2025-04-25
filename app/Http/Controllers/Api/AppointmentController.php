<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       
        $appointments = Appointment::with(['department', 'doctor', 'user'])->get();
        return response()->json($appointments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'department_id' => 'required|exists:departments,id',
            'doctor_id' => 'required|exists:doctors,id',
            'subject' => 'required|string|max:255',
            'prescription' => 'nullable|string',
            'time_slot' => 'required|string', 
        ]);

        // Create the appointment and associate it with the authenticated user
        $appointment = Appointment::create([
            'user_id' => Auth::id(), // Associate the authenticated user
            'department_id' => $request->department_id,
            'doctor_id' => $request->doctor_id,
            'subject' => $request->subject,
            'prescription' => $request->prescription,
            'time_slot' => $request->time_slot,
        ]);

        return response()->json($appointment, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment)
    {
        // Load the associated department, doctor, and user for the specified appointment
        return response()->json($appointment->load(['department', 'doctor', 'user']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appointment $appointment)
    {
        $request->validate([
            'department_id' => 'sometimes|required|exists:departments,id',
            'doctor_id' => 'sometimes|required|exists:doctors,id',
            'subject' => 'sometimes|required|string|max:255',
            'prescription' => 'nullable|string',
            'time_slot' => 'sometimes|required|string',
        ]);

        $appointment->update($request->all());

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
}
