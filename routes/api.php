<?php

use App\Http\Controllers\Api\V1\AuthController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1'], function() {
    Route::post('login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('logout', [AuthController::class, 'logout'])->middleware(['auth:sanctum'])->name('auth.logout');
    Route::post('register', [AuthController::class, 'register'])->name('auth.register');

    Route::put('verify-account', [AuthController::class, 'verifyAccount'])->name('auth.verify-account');
    Route::post('resend-code', [AuthController::class, 'resendVerificationCode'])->name('auth.resend-code');

    Route::post('forget-password', [AuthController::class, 'forgetPassword'])->name('auth.forget-password');
    Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('auth.reset-password');
});

