<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::middleware('can:admin_panel')->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin');
    Route::post('/settings', [AdminController::class, 'settingsUpdate'])->name('admin.settings.update');
});
