<?php

namespace App\Http\Controllers\Webhook;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Process;

class ContinuousDeploymentController extends Controller
{
    public function githubWebhook(Request $request)
    {
        if (config('app.path') === null) {
            abort(500, 'Server is not configured to receive this webhook (App path is not defined).');
        }

        $signature = 'sha256=' . hash_hmac('sha256', $request->getContent(), config('services.github.webhook_secret'));
        if (!hash_equals($signature, $request->header('X-Hub-Signature-256'))) {
            abort(403, 'Invalid signature');
        }

        Log::info('Deploying changes from GitHub...');

        $result = Process::run([
            'bash', '-c',
            'cd ' . config('app.path') . ' && git pull origin main'
        ]);

        if (!$result->successful()) {
            Log::info('Deployment output: ' . $result->output());
            Log::error('Deployment errors: ' . $result->errorOutput());
            return response('Deployment failed', 500);
        }

        Log::info('Deployment successful: ' . $result->output());
        return response('Deployment successful', 200);
    }
}
