<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class UserController extends Controller
{
    public function register(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'full_name' => 'required|string|max:255',
            'resident_number' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15',
            'birthday' => 'required|date|before:today',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'insurance' => 'required|string', // Validate as string
        ]);

        // Convert the insurance input to a boolean
        $insurance = $request->input('insurance') === 'true'; // Convert string to boolean

        // Generate a unique Patient ID
        do {
            $patientId = random_int(1000000, 9999999);
        } while (User ::where('patient_id', $patientId)->exists());

        // Create the user
        $user = User::create([
            'patient_id' => $patientId,
            'full_name' => $request->input('full_name'),
            'resident_number' => $request->input('resident_number'),
            'phone_number' => $request->input('phone_number'),
            'birthday' => $request->input('birthday'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'insurance' => $insurance, // Use the converted boolean value
        ]);

        // Return a success response
        return response()->json(['message' => 'User  registered successfully!', 'user' => $user], 201);
    }

    public function login(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'identifier' => 'required|string', // This will be either email or resident number
            'password' => 'required|string|min:8', // Ensure password is provided
        ]);
    
        // Retrieve the identifier (email or resident number)
        $identifier = $request->input('identifier');
    
        // Attempt to authenticate the user
        $user = User::where('email', $identifier)
                    ->orWhere('resident_number', $identifier)
                    ->first();
    
        // Check if user exists and password is correct
        if ($user && Hash::check($request->input('password'), $user->password)) {
            // Log the user in
            Auth::login($user);
    
            // Create a token for the user
            $token = $user->createToken('YourAppName')->plainTextToken;
    
            // Return a success response with the token
            return response()->json([
                'message' => 'Login successful!',
                'user' => $user,
                'token' => $token // Include the token in the response
            ], 200);
        }
    
        // Return an error response if authentication fails
        return response()->json(['message' => 'Invalid credentials.'], 401);
    }

    public function profile()
    {
        $userdata = auth()->user();

        return response()->json([
            'status' => true,
            'message' => 'Profile data',
            'data' => $userdata
        ]);
    }

    public function update(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'full_name' => 'sometimes|required|string|max:255',
            'resident_number' => 'sometimes|required|string|max:255',
            'phone_number' => 'sometimes|required|string|max:15',
            'birthday' => 'sometimes|required|date|before:today',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . auth()->id(),
            'insurance' => 'sometimes|required|string', // Validate as string
        ]);

        // Get the authenticated user
        $user = auth()->user();

        // Update the user's profile with the validated data
        if ($request->has('full_name')) {
            $user->full_name = $request->input('full_name');
        }
        if ($request->has('resident_number')) {
            $user->resident_number = $request->input('resident_number');
        }
        if ($request->has('phone_number')) {
            $user->phone_number = $request->input('phone_number');
        }
        if ($request->has('birthday')) {
            $user->birthday = $request->input('birthday');
        }
        if ($request->has('email')) {
            $user->email = $request->input('email');
        }
        if ($request->has('insurance')) {
            $user->insurance = $request->input('insurance') === 'true'; // Convert string to boolean
        }

        // Save the updated user
        $user->save();

        // Return a success response
        return response()->json(['message' => 'Profile updated successfully!', 'user' => $user], 200);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            'status' => true,
            'message' => 'User logged out'
        ]);
    }
}
