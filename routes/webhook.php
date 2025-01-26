<?php

use App\Http\Controllers\Webhook\ContinuousDeploymentController;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;

Route::withoutMiddleware(VerifyCsrfToken::class)->prefix('/webhook')->group(function () {
    if (config('services.github.webhook_secret') !== null) {
        Route::post('/github', [ContinuousDeploymentController::class, 'githubWebhook']);
    }
});
