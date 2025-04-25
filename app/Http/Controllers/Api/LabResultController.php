<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LabResult;
use Illuminate\Http\Request;

class LabResultController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return LabResult::with('user')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'result_type' => 'required|string|in:text,image,pdf',
            'result_data' => 'required|array',
        ]);
    
        $resultData = [];
    
        if ($request->result_type === 'text') {
            // Validate that the text field is present
            $request->validate([
                'result_data.text' => 'required|string',
            ]);
            $resultData = $request->input('result_data.text');
        } else {
            // Validate that files are present
            $request->validate([
                'result_data.*' => 'file|mimes:jpg,jpeg,png,pdf|max:2048',
            ]);
            foreach ($request->file('result_data') as $file) {
                $path = $file->store('lab_results');
                $resultData[] = $path;
            }
        }
    
        $labResult = LabResult::create([
            'user_id' => $request->user()->id, // Associate with authenticated user
            'result_type' => $request->result_type,
            'result_data' => json_encode($resultData),
        ]);
    
        return response()->json($labResult, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(LabResult $labResult)
    {
        return LabResult::with('user')->findOrFail($labResult);
    }

   
    public function update(Request $request, LabResult $labResult)
    {
        // Validate the incoming request
        $request->validate([
            'result_type' => 'sometimes|required|string|in:text,image,pdf',
            'result_data' => 'sometimes|required|array',
        ]);

        // Update the fields that are present in the request
        if ($request->has('result_type')) {
            $labResult->result_type = $request->result_type;
        }

        if ($request->has('result_data')) {
            // Handle updating result_data similarly to the store method
            if ($request->result_type === 'text') {
                // Validate that the text field is present
                $request->validate([
                    'result_data.text' => 'required|string',
                ]);
                $labResult->result_data = json_encode($request->input('result_data.text'));
            } else {
                // Validate that files are present
                $request->validate([
                    'result_data.*' => 'file|mimes:jpg,jpeg,png,pdf|max:2048',
                ]);
                $resultData = [];
                foreach ($request->file('result_data') as $file) {
                    $path = $file->store('lab_results');
                    $resultData[] = $path;
                }
                $labResult->result_data = json_encode($resultData);
            }
        }

        // Save the updated model
        $labResult->save();

        // Return a response with the updated lab result
        return response()->json($labResult->load('user'), 200);
    }
    
   
    public function destroy(LabResult $labResult)
    {
        // Optionally, check if the user is authorized to delete this lab result
        if ($labResult->user_id !== request()->user()->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Delete the lab result
        $labResult->delete();

        // Return a 204 No Content response
        return response()->json(['message' => 'Lab result has been deleted successfully.'], 200);
    }
}
