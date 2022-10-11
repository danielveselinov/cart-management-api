<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Address\Http\Controllers\Api\V1\AddressController;

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

Route::middleware('auth:api')->get('/address', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1', 'middleware' => 'auth:sanctum'], function() {
    Route::apiResource('address', AddressController::class)->except('show');
    Route::post('select/address', [AddressController::class, 'selectAddress'])->name('select.address');
});