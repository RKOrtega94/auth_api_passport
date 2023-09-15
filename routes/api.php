<?php

use App\Http\Controllers\AuthController;
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

/**
 * Auth routes
 */
Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login'); // /api/login
    Route::post('register', 'register'); // /api/register
    Route::post('forgot-password', 'forgotPassword'); // /api/forgot-password
    Route::post('reset-password', 'resetPassword'); // /api/reset-password
});
