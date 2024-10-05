<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');


Route::post('auth/login', [
    \App\Http\Controllers\LoginController::class,
    'login'
])->name('login');

Route::get('products', [
    ProductController::class,
    'index'
]);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('products', ProductController::class)
        ->only(['store', 'update', 'destroy']);

    Route::apiResource('carts', CartController::class)
        ->only(['index', 'store']);
});


