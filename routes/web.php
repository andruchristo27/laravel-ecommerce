<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductImageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Middleware\AdminMiddleware;


Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return redirect('/login');
    });
    Route::get('/register', [AuthenticationController::class, 'registerForm'])->name('registerForm');
    Route::post('/register', [AuthenticationController::class, 'register'])->name('register');
    Route::get('/login', [AuthenticationController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthenticationController::class, 'login']);
});

Route::middleware([AdminMiddleware::class])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('categories', CategoryController::class);
    Route::get('categories/data', [CategoryController::class, 'show'])->name('categories.data');
    Route::resource('products', ProductController::class);
    Route::get('products/data', [ProductController::class, 'show'])->name('products.data');
    Route::delete('products/{product}/images/{image}', [ProductImageController::class, 'destroy'])->name('products.images.destroy');
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('users/{id}', [UserController::class, 'show'])->name('users.show');
    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/logout', [AuthenticationController::class, 'logout'])->name('logout');
});