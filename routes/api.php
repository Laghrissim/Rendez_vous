<?php

use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\DocteurController;
use App\Http\Controllers\SecretController;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\api\ChatController;
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
    return $request->user()->only(['id','name','email','profile_picture','type']);
});
Route::middleware('auth:sanctum')->get('/check-authentication', function (Request $request) {
    return response()->json(['authenticated' => $request->user() !== null]);
});

// Routes for Doctor Authentication using Sanctum Middleware
Route::middleware('auth:sanctum')->group(function () {
    // Retrieve authenticated doctor's data
// Route for fetching authenticated doctor's data using Sanctum Middleware
Route::middleware('auth:sanctum')->get('/doctor', function (Request $request) {
    return $request->user('docteur')->only(['id', 'name', 'email', 'profile_picture', 'type']);
});
    
    // Check if a doctor is authenticated
    Route::middleware('auth:sanctum')->get('/docteur/check-authentication', function (Request $request) {
        return response()->json(['authenticated' => $request->user('docteur') !== null]);
    });
    
});

//Appointements
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/appointments', [AppointmentController::class, 'index']);
    Route::get('/doctorAppointments', [AppointmentController::class, 'doctorApointment']);
    Route::post('/appointments', [AppointmentController::class, 'store']);
    // Route::get('/appointments/{id}', [AppointmentController::class, 'show']);
    Route::put('/appointments/edit/{id}', [AppointmentController::class, 'edit']);
    Route::delete('/appointments/{id}', [AppointmentController::class, 'destroy']);
});
    


Route::get('/getDates', [AppointmentController::class, 'getDates']);
Route::post('/upload-image', [ClientController::class, 'uploadImage']);
Route::get('/doctors', [DocteurController::class, 'getDoctors']);
Route::get('/doctor/{id}', [DocteurController::class, 'getDoctor']);
Route::post('/comments', [CommentController::class, 'store']);
Route::get('/comments', [CommentController::class, 'index']);
Route::put('/comments/{id}', [CommentController::class, 'update']);
Route::delete('/comments/{id}', [CommentController::class, 'destroy']);


// Route to send a message
Route::post('messages', [ChatController::class, 'sendMessage']);

// Route to get messages between two users
Route::get('messages', [ChatController::class, 'getMessages']);
Route::delete('messages/{id}', [ChatController::class, 'deleteMessage']);
Route::get('/doctors/{doctorId}', [AppointmentController::class, 'getClientsForDoctor']);


// Route::post('/clients/{clientId}/appointments', [ClientController::class, 'storeAppointment']); 
// Route::post('/clients', [ClientController::class, 'store']);
// Route::post('/clients/register', [ClientController::class, 'register']);
// Route::post('/clients/login', [ClientController::class, 'login']);











// Route::post('/register', [RegisteredUserController::class, 'store']);
// Route::post('/login', [AuthenticatedSessionController::class, 'store']);
// Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);


