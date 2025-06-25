<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\User\IkoaProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\Admin\ProductController ;
use App\Http\Controllers\Api\User\ReviewController ;
use App\Http\Controllers\Api\Admin\CategoryController;
use App\Http\Controllers\Api\Admin\OrderController;
use App\Http\Controllers\Api\ikoa\UserController;
use App\Http\Controllers\Api\Ikoa\CartController;



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//admin

Route::post('/register', [AuthController::class, 'register']);   // ★任意
Route::post('/login',    [AuthController::class, 'login'])->name('api.login');

Route::post('/admin_register', [AuthController::class, 'adminRegister']);   // ★任意
Route::post('/admin_login',    [AuthController::class, 'adminLogin'])->name('api.login');

Route::get('/user/products/list', [IkoaProductController::class, 'list']);
Route::apiResource('user/products', IkoaProductController::class);
Route::get('/reviews/index', [ReviewController::class,'index']);
//review画面のルート

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});

//カート機能のルート
Route::apiResource('cart', CartController::class);

    Route::middleware(['auth:sanctum','can:user'])->group(function () {
        Route::apiResource('admin/products', ProductController::class);
        Route::get('/reviews/create', [ReviewController::class, 'create']);
        Route::apiResource('reviews', ReviewController::class)->only(['store','update','destroy']);
        Route::get('user/mypage', [UserController::class, 'mypage']);
    });


// role >= true のユーザーだけがアクセスできる
Route::middleware(['auth:sanctum','can:admin'])->group(function () {
    Route::apiResource('admin/products', ProductController::class);
    Route::apiResource('admin/categories', CategoryController::class);
    Route::apiResource('admin/users', UserController::class);
    Route::apiResource('admin/orders', OrderController::class);
});

