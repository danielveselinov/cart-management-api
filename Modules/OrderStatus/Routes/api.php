<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\OrderStatus\Http\Controllers\Api\V1\OrderStatusController;

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

Route::middleware('auth:api')->get('/orderstatus', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1', 'middleware' => 'auth:sanctum'], function() {
    Route::get('order-statuses', [OrderStatusController::class, 'index'])->name('order.statuses')->middleware(['ensureisadmin']);
    Route::put('update-order-status/{order}', [OrderStatusController::class, 'update'])->name('order.status.update')->middleware(['ensureisadmin']);
});