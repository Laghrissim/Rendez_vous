<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ClientController;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/clients/{id}', [ClientController::class, 'show']);
Route::post('/clients/{clientId}/appointments', [ClientController::class, 'storeAppointment']); 
Route::post('/clients', [ClientController::class, 'store']);
Route::post('/clients/register', [ClientController::class, 'register']);
Route::post('/clients/login', [ClientController::class, 'login']);





