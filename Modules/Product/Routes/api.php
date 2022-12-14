<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Product\Http\Controllers\Api\V1\ProductController;

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

Route::middleware('auth:api')->get('/product', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1'], function() {
    Route::apiResource('product', ProductController::class);
    Route::get('filter', [ProductController::class, 'filter']);

    Route::delete('product/{product}/force', [ProductController::class, 'delete'])->name('product.delete');
    
    Route::post('product/{product}/restore/', [ProductController::class, 'restore'])->name('product.restore');
});