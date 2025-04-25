<?php


use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\DepartmentController;
use App\Http\Controllers\Api\DoctorController;
use App\Http\Controllers\Api\LabResultController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;






Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum'] ], function()
{
    Route::get('profile', [UserController::class, 'profile']);
    Route::put('profile', [UserController::class, 'update']);
    Route::get('logout', [UserController::class, 'logout']);
    
    Route::apiResource('lab-results', LabResultController::class);
    Route::apiResource('appointments', AppointmentController::class);

    Route::post('appointments/get-departments-and-doctors', [AppointmentController::class, 'getDepartmentsAndDoctors']);
});

Route::apiResource('locations', LocationController::class);
Route::apiResource('departments', DepartmentController::class);
Route::apiResource('doctors', DoctorController::class);



// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
