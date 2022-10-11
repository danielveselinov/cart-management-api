<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\PaymentType\Http\Controllers\Api\V1\PaymentTypeController;

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

Route::middleware('auth:api')->get('/paymenttype', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1', 'middleware' => 'auth:sanctum'], function() {
    Route::post('select/payment', [PaymentTypeController::class, 'selectPayment'])->name('select.payment');
});