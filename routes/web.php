<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class);

Route::get('/search', [SearchController::class, 'search'])->name('search');

Route::get('/upload', [PostController::class, 'create'])->name('upload');

Route::post('/posts/{post}/tags', [PostController::class, 'updateTags'])->name('posts.tags');
Route::post('/posts/{post}/setVisibility', [PostController::class, 'setVisibility'])->name('posts.setVisibility');
Route::post('/posts/{post}/addComment', [PostController::class, 'addComment'])->name('posts.addComment');

Route::resource('posts', PostController::class)->only('show', 'store', 'destroy');
Route::resource('users', UserController::class)->only('index', 'show', 'store');
Route::resource('tags', TagController::class)->only('index', 'show');
Route::resource('comments', CommentController::class)->only('update', 'destroy');

Route::middleware('cache.headers:public;max_age=2628000;etag')->group(function () {
    Route::get('_image/{hash}', [FileController::class, 'image'])->where('hash', '[0-9a-f]+')->name('_image');
    Route::get('_thumb/{hash}', [FileController::class, 'thumb'])->where('hash', '[0-9a-f]+')->name('_thumb');
});

require __DIR__ . '/webhook.php';
require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
