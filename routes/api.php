<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('user', [AuthController::class, 'user'])->name('user');
    Route::apiResource('users', \App\Http\Controllers\UserController::class)->except(['store', 'update']);
    Route::apiResource('sales-requests', \App\Http\Controllers\SalesRequestController::class);
    Route::apiResource('payments', \App\Http\Controllers\PaymentController::class)->except(['update', 'destroy']);
    Route::apiResource('locations', \App\Http\Controllers\LocationController::class);
});
