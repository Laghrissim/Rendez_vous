<?php

use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\SecretController;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::get('/check-authentication', function (Request $request) {
//     return response()->json(['authenticated' => $request->user() !== null]);
// });
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user()->only(['name','email']);
});
Route::middleware('auth:sanctum')->get('/check-authentication', function (Request $request) {
    return response()->json(['authenticated' => $request->user() !== null]);
});

//Appointements
Route::middleware('auth:sanctum')->group(function () {
    // Route::get('/appointments', [AppointmentController::class, 'index']);
    Route::post('/appointments', [AppointmentController::class, 'store']);
    // Route::get('/appointments/{id}', [AppointmentController::class, 'show']);
    Route::put('/appointments/edit/{id}', [AppointmentController::class, 'edit']);

    // Route::delete('/appointments/{id}', [AppointmentController::class, 'destroy']);
});
   Route::get('/appointments', [AppointmentController::class, 'index']);
    
    Route::get('/appointments/{id}', [AppointmentController::class, 'show']);
    Route::delete('/appointments/{id}', [AppointmentController::class, 'destroy']);


    Route::get('/getDates', [AppointmentController::class, 'getDates']);

// Route::get('/clients/{id}', [ClientController::class, 'show']);
// Route::post('/clients/{clientId}/appointments', [ClientController::class, 'storeAppointment']); 
// Route::post('/clients', [ClientController::class, 'store']);
// Route::post('/clients/register', [ClientController::class, 'register']);
// Route::post('/clients/login', [ClientController::class, 'login']);











// Route::post('/register', [RegisteredUserController::class, 'store']);
// Route::post('/login', [AuthenticatedSessionController::class, 'store']);
// Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);


