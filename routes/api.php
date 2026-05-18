<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\AuthController;
// use App\Http\Controllers\Api\TransactionController;

Route::prefix('v1')->group(function () {

    // AUTH
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        
        // USER PROFILE
        Route::get('/user/me', [AuthController::class, 'me']);
        Route::put('/user/profile', [AuthController::class, 'updateProfile']);
        Route::post('/user/photo', [AuthController::class, 'uploadPhoto']);
        Route::get('/user/photo', [AuthController::class, 'getPhoto']);
        Route::delete('/user/photo', [AuthController::class, 'deletePhoto']);
        Route::post('/logout', [AuthController::class, 'logout']);
        
        // TRANSACTION [Soon]
        // Route::get('/cart', [TransactionController::class, 'getCart']);     
        // Route::post('/cart/reduce', [TransactionController::class, 'reduceItem']); 
        // Route::post('/checkout', [TransactionController::class, 'checkout']);
        // Route::post('/pay', [TransactionController::class, 'pay']);       
        // Route::delete('/cart/clear', [TransactionController::class, 'clearCart']);  
        // Route::get('/history', [TransactionController::class, 'history']);
    });    

    // PRODUCT 
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{id}', [ProductController::class, 'show']);

});