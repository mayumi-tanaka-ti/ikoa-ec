<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\IkoaProductController;
use App\Http\Controllers\AuthController;
<<<<<<< HEAD
use App\Http\Controllers\Api\Admin\ProductController as IkoaProductController;
use App\Admin\UserController;
=======
use App\Http\Controllers\Api\Admin\ProductController ;
>>>>>>> 75455eba35b546593f4068c9d8c1b803018e386b

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::get('/products/list', [IkoaProductController::class, 'list']);

<<<<<<< HEAD
=======
Route::apiResource('products', IkoaProductController::class)->only(['index','show']);

>>>>>>> 75455eba35b546593f4068c9d8c1b803018e386b

Route::post('/register', [AuthController::class, 'register']);   // ★任意
Route::post('/login',    [AuthController::class, 'login'])->name('api.login');


Route::post('/admin_register', [AuthController::class, 'adminRegister']);   // ★任意
Route::post('/admin_login',    [AuthController::class, 'adminLogin'])->name('api.login');
// Route::apiResource('products', ProductController::class);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});

    
    // role >= true のユーザーだけがアクセスできる
    //管理者側
    Route::middleware(['auth:sanctum','can:admin'])->group(function () {
        Route::apiResource('products', ProductController::class);
        Route::get('/admin/users', [UserController::class, 'index']);
        Route::get('/admin/users/{id}', [UserController::class, 'show']);
        Route::get('/admin/users/{id}/history', [UserController::class, 'history']);
    });
    //ユーザー側
    Route::middleware(['auth:sanctum','can:user'])->group(function () {
        Route::apiResource('products', ProductController::class);
    });
