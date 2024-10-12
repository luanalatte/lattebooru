<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class);

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/register', [RegisterController::class, 'index'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/upload', [PostController::class, 'create'])->name('upload');
    Route::post('/upload', [PostController::class, 'store']);
});

Route::get('/post/{post}', [PostController::class, 'show'])->name('post.show');
Route::post('/post/{post}/delete', [PostController::class, 'destroy'])->name('post.delete');

Route::middleware('cache.headers:public;max_age=2628000;etag')->group(function () {
    Route::get('_image/{hash}', [FileController::class, 'image'])->where('hash', '[0-9a-f]+')->name('_image');
    Route::get('_thumb/{hash}', [FileController::class, 'thumb'])->where('hash', '[0-9a-f]+')->name('_thumb');
});
