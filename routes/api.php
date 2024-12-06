<?php




use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middl<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/**
 * route "/register"
 * @method "POST"
 */
// Route::post('/register', App\Http\Controllers\Api\RegisterController::class)->name('register');

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;



Route::post('/register',[RegisterController::class,'register']); 


/**
 * route "/login"
 * @method "POST"
 */
Route::post('/login', [LoginController::class, 'login']);

/**
 * route "/user"
 * @method "GET"
 */
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::post('/logout',App\Http\Controllers\Api\LogoutController::class)->name('logout');

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
use App\http\Controllers\UserController;
Route::middleware('auth:api')->put('/updateuser/{id}',[UserController::class,'updateuser']);
Route::middleware('auth:api')->delete('/delete/{id}',[UserController::class,'delete']);
Route::middleware('auth:api')->get('/getUserById/{id}',[UserController::class,'getUserById']);

use App\Http\Controllers\KehadiranController;
Route::middleware('auth:api')->post('/attendance', [KehadiranController::class, 'presensi']);
Route::middleware('auth:api')->get('/attendance/history/{id}',[KehadiranController::class,'show1']);
Route::middleware('auth:api')->get('/attendance/summary/{id}',[KehadiranController::class,'summary']);
Route::middleware('auth:api')->post('/attendance/analysis', [KehadiranController::class,'analysis']);





