<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\User\IkoaProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\Admin\ProductController ;
use App\Http\Controllers\Api\User\ReviewController ;
use App\Http\Controllers\Api\Admin\CategoryController;
use App\Http\Controllers\Api\Admin\OrderController;
use App\Http\Controllers\Api\Admin\AdminController;
use App\Http\Controllers\Api\Ikoa\UserController;
use App\Http\Controllers\Api\Ikoa\CartController;


//管理側-----

Route::post('/admin_register', [AuthController::class, 'adminRegister']);   // ★任意
Route::post('/admin_login',    [AuthController::class, 'adminLogin'])->name('api.login');

Route::get('/user/products/list', [IkoaProductController::class, 'list']);
Route::apiResource('user/products', IkoaProductController::class);
Route::get('/reviews/index', [ReviewController::class,'index']);

Route::middleware(['auth:sanctum','can:admin'])->group(function () {
    Route::apiResource('admin/products', ProductController::class);
    Route::get('admin/products/category', [CategoryController::class, 'category']);
    Route::apiResource('admin/categories', CategoryController::class);
    Route::get('admin/history/{id}', [AdminController::class,'history']);
    Route::apiResource('admin/users', AdminController::class);
    Route::apiResource('admin/orders', OrderController::class);
});

//ユーザー側-----

Route::post('/register', [AuthController::class, 'register']);   // ★任意
Route::post('/login',    [AuthController::class, 'login'])->name('api.login');
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::apiResource('user/products', IkoaProductController::class);
Route::get('/cart/complete/{order}', [CartController::class, 'complete']);

Route::middleware(['auth:sanctum','can:user'])->group(function () {
    Route::get('/reviews/create', [ReviewController::class, 'create']);
    Route::apiResource('reviews', ReviewController::class);
    Route::get('user/mypage', [UserController::class, 'mypage']);
    Route::put('user/mypage', [UserController::class, 'update']);
    Route::apiResource('cart', CartController::class); //カート機能のルート
    Route::post('cart/purchase', [CartController::class, 'purchase']);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');