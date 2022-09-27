<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Cart\Http\Controllers\Api\V1\CartController;

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

Route::middleware('auth:api')->get('/cart', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1', 'middleware' => 'auth:sanctum'], function() {
    // store, update, delete, checkout
    Route::post('cart-item', [CartController::class, 'store'])->name('cart.item.store');
    Route::put('cart-item/{cart}', [CartController::class, 'update'])->name('cart.item.update');
    Route::delete('cart-item/{cartItemId}', [CartController::class, 'destroy'])->name('cart.item.destroy');
    Route::post('checkout', [CartController::class, 'checkout'])->name('cart.checkout');
});