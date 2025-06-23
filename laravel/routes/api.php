<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\Admin\ProductController;

Route::post('/register', [AuthController::class, 'register']);   // ★任意
Route::post('/login',    [AuthController::class, 'login'])->name('api.login');

// Route::apiResource('products', ProductController::class);

// auth:sanctumで囲むとトークン必要(ログイン必要)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('products', ProductController::class);
});

