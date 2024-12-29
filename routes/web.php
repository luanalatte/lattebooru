<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use App\Models\Post;
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

    Route::get('/upload', [PostController::class, 'create'])->can('create', Post::class)->name('upload');
    Route::post('/upload', [PostController::class, 'store'])->can('create', Post::class);
});

Route::get('/post/{post}', [PostController::class, 'show'])->can('view', 'post')->name('post.show');
Route::post('/post/{post}', [PostController::class, 'update'])->can('update', 'post')->name('post.update');
Route::post('/post/{post}/tags', [PostController::class, 'updateTags'])->can('post_edit_tags', 'post')->name('post.tags');
Route::post('/post/{post}/setVisibility', [PostController::class, 'setVisibility'])->can('update', 'post')->name('post.setVisibility');
Route::post('/post/{post}/delete', [PostController::class, 'destroy'])->can('delete', 'post')->name('post.delete');

Route::get('/users', [UserController::class, 'index'])->name('users');
Route::get('/user/{user}', [UserController::class, 'show'])->name('user.show');

Route::get('/tags', [TagController::class, 'index'])->name('tags');
Route::get('/tag/{tag}', [TagController::class, 'show'])->name('tag.show');

Route::middleware('can:admin_panel')->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin');
});

Route::middleware('cache.headers:public;max_age=2628000;etag')->group(function () {
    Route::get('_image/{hash}', [FileController::class, 'image'])->where('hash', '[0-9a-f]+')->name('_image');
    Route::get('_thumb/{hash}', [FileController::class, 'thumb'])->where('hash', '[0-9a-f]+')->name('_thumb');
});
