<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\OrderController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [UserController::class, 'show']);
    Route::put('/user/update', [UserController::class, 'update']);
    Route::post('/logout', [UserController::class, 'logout']);
    
    Route::get('/products', [ProductController::class, 'index']);
    
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart/add', [CartController::class, 'add']);
    Route::delete('/cart/{id}', [CartController::class, 'delete']);
    Route::put('/cart/{id}', [CartController::class, 'update']);

    Route::post('/checkout/cart', [OrderController::class, 'checkoutFromCart']);
    Route::post('/checkout/product', [OrderController::class, 'checkoutFromProduct']);
    Route::get('/orders', [OrderController::class, 'index']);

    Route::post('/midtrans/callback', [OrderController::class, 'handleCallback']);
});

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::get('/products', [ProductController::class, 'index']);
