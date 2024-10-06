<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('auth/login', [LoginController::class, 'login'])
    ->name('login');

Route::get('products', [ProductController::class, 'index'])
    ->name('products.index');

Route::middleware(['auth:sanctum'])
    ->group(function () {
        Route::get('my-cart', [UserController::class, 'myCart'])
            ->name('users.my-cart');

        Route::apiResource('products', ProductController::class)
            ->only(['store', 'update', 'destroy']);

        Route::apiResource('carts', CartController::class)
            ->only(['index', 'show', 'store']);

        Route::put('cart-items/{item}/quantity', [CartItemController::class, 'quantity'])
            ->name('cart-items.quantity');

        Route::delete('cart-items/{item}', [CartItemController::class, 'destroy'])
            ->name('cart-items.destroy');
    });