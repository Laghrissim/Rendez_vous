<?php

use App\Http\Controllers\Api\AdminController;
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

Route::get('/admin', function () {
    return view('admin');
});
// Route::get('/client', function () {
//     return view('client');
// });
// Route::get('/doctor', function () {
//     return view('doctor');
// });


Route::post('/admin',[AdminController::class,'adminLogin']);

Route::post('/admin/register',[AdminController::class,'createAdmin']);

Route::post('/admin/logout',[AdminController::class,'adminLogout']);

// Route::post('/login',[UserController::class,'Login']);

// Route::post('/register',[UserController::class,'create']);

// Route::post('/logout',[UserController::class,'Logout']);





Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

