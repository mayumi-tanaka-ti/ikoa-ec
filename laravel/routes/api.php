<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\User\IkoaProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\Admin\ProductController ;
use App\Http\Controllers\Api\User\ReviewController ;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Api\ikoa\IkoaProductController;
use App\Http\Controllers\Api\ikoa\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\Admin\CategoryController;
use App\Http\Controllers\Api\Admin\OrderController;
use App\Http\Controllers\Api\Admin\ProductController;
use App\Http\Controllers\Api\Admin\UserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware(['auth:sanctum','can:user'])->group(function () {
    Route::apiResource('user/products', IkoaProductController::class);
    Route::apiResource('user/mypage', UserController::class);
});


//admin

Route::post('/register', [AuthController::class, 'register']);   // ★任意
Route::post('/login',    [AuthController::class, 'login'])->name('api.login');

Route::post('/admin_register', [AuthController::class, 'adminRegister']);   // ★任意
Route::post('/admin_login',    [AuthController::class, 'adminLogin'])->name('api.login');


Route::apiResource('reviews', ReviewController::class)->only(['index']);
//review画面のルート

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});

    // role >= true のユーザーだけがアクセスできる
    Route::middleware(['auth:sanctum','can:admin'])->group(function () {
        Route::apiResource('/admin_products', ProductController::class);
    });
    Route::middleware(['auth:sanctum','can:user'])->group(function () {
        Route::apiResource('/admin_products', ProductController::class);
        Route::get('/reviews/create', [ReviewController::class, 'create']);
        Route::apiResource('reviews', ReviewController::class)->only(['store','update','destroy']);
        Route::apiResource('user/mypage', UserController::class);
    });


// role >= true のユーザーだけがアクセスできる
Route::middleware(['auth:sanctum','can:admin'])->group(function () {
    Route::apiResource('admin/products', ProductController::class);
    Route::apiResource('admin/categories', CategoryController::class);
    Route::apiResource('admin/users', UserController::class);
    Route::apiResource('admin/orders', OrderController::class);
});

