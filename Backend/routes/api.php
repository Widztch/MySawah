<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controlers\Admin\OrderController as AdminOrderController;

// ==========================================================
// RUTE USER
// ==========================================================
Route::prefix('v1')->group(function () {

    // Authentication (Registrasi & Login)
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        
        // User
        Route::get('/user/me', [AuthController::class, 'me']);
        Route::put('/user/profile', [AuthController::class, 'updateProfile']);
        Route::post('/user/photo', [AuthController::class, 'uploadPhoto']);
        Route::get('/user/photo', [AuthController::class, 'getPhoto']);
        Route::delete('/user/photo', [AuthController::class, 'deletePhoto']);
        Route::post('/logout', [AuthController::class, 'logout']);
        
        // Transaksi
        Route::get('/cart', [TransactionController::class, 'getCart']);     
        Route::post('/cart/reduce', [TransactionController::class, 'reduceItem']); 
        Route::post('/checkout', [TransactionController::class, 'checkout']);
        Route::post('/pay', [TransactionController::class, 'pay']);       
        Route::delete('/cart/clear', [TransactionController::class, 'clearCart']);  
        Route::get('/history', [TransactionController::class, 'history']);
    });    

    // Product (Public)
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{id}', [ProductController::class, 'show']);

});

// ==========================================================
// RUTE ADMIN
// ==========================================================
Route::prefix('v1/admin')->middleware(['auth:sanctum', 'admin'])->group(function () {
    
    // Kelola Produk
    Route::post('/products', [AdminProductController::class, 'store']);
    Route::post('/products/{id}', [AdminProductController::class, 'update']); 
    // Delete
    Route::delete('/products/bulk', [AdminProductController::class, 'destroyBulk']); 
    Route::delete('/products/{id}', [AdminProductController::class, 'destroy']);

    // Laporan
    Route::get('/dashboard/omzet', [AdminOrderController::class, 'omzetReport']);
    
    // Kelola Pesanan
    Route::get('/orders', [AdminOrderController::class, 'index']);
    Route::get('/orders/{id}', [AdminOrderController::class, 'show']);
    Route::put('/orders/{id}/status', [AdminOrderController::class, 'updateStatus']);

});