<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// 管理者用のトップページ
Route::get('/admin/index', function () {
    return file_get_contents(public_path('admin/index.html'));
});
