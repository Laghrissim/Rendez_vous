<?php

use App\Http\Controllers\Api\DocteurController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use Illuminate\Http\Request;
use Laravel\Dusk\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::get('/', function () {
    return view('app');
});
// Route::get('/client', function () {
//     return view('client');
// });
// Route::get('/doctor', function () {
//     return view('doctor');
// });


Route::post('/docteur',[DocteurController::class,'docteurLogin']);

Route::post('/docteur/register',[DocteurController::class,'createDoctor']);

Route::post('/docteur/logout',[DocteurController::class,'docteurLogout']);

// Route::post('/login',[UserController::class,'Login']);

// Route::post('/register',[UserController::class,'create']);

// Route::post('/logout',[UserController::class,'Logout']);





Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

