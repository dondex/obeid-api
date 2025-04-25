<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LocationController extends Controller
{
    public function index()
    {
        return Location::all();
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'image' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'department_id' => 'required|exists:departments,id',
            'doctor_id' => 'required|exists:doctors,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Handle the image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images/locations', 'public'); // Store in public/images/locations
        }

        // Create the location
        $location = Location::create([
            'name' => $request->name,
            'image' => $imagePath, // Save the path to the database
            'department_id' => $request->department_id,
            'doctor_id' => $request->doctor_id,
        ]);

        return response()->json($location, 201);
    }

    public function show($id)
    {
        $location = Location::find($id);
        if (!$location) {
            return response()->json(['message' => 'Location not found'], 404);
        }
        return response()->json($location);
    }

    public function update(Request $request, $id)
    {
        $location = Location::find($id);
        if (!$location) {
            return response()->json(['message' => 'Location not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'image' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'department_id' => 'sometimes|required|exists:departments,id',
            'doctor_id' => 'sometimes|required|exists:doctors,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Handle the image upload if a new image is provided
        $imagePath = $location->image; // Keep the existing image path by default
        if ($request->hasFile('image')) {
            // Delete the old image if necessary (optional)
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath); // Delete the old image from storage
            }
            // Store the new image
            $imagePath = $request->file('image')->store('images/locations', 'public');
        }

        // Update the location with the new data
        $location->update([
            'name' => $request->name ?? $location->name, // Use existing name if not provided
            'image' => $imagePath, // Update the image path
            'department_id' => $request->department_id ?? $location->department_id, // Use existing department_id if not provided
            'doctor_id' => $request->doctor_id ?? $location->doctor_id, // Use existing doctor_id if not provided
        ]);

        return response()->json($location);
    }

    public function destroy($id)
    {
        $location = Location::find($id);
        if (!$location) {
            return response()->json(['message' => 'Location not found'], 404);
        }

        $location->delete();
        return response()->json(['message' => 'Location deleted successfully']);
    }
}