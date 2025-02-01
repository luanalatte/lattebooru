<?php

namespace App\Http\Controllers\Webhook;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Process;

class ContinuousDeploymentController extends Controller
{
    public function githubWebhook(Request $request)
    {
        $signature = 'sha256=' . hash_hmac('sha256', $request->getContent(), config('services.github.webhook_secret'));
        if (!hash_equals($signature, $request->header('X-Hub-Signature-256'))) {
            abort(403, 'Invalid signature.');
        }

        $event = $request->header('X-GitHub-Event');
        if ($event !== 'push') {
            abort(400, 'Unsupported event type.');
        }

        if (!file_exists(base_path() . '/deploy.sh') || !is_executable(base_path() . '/deploy.sh')) {
            Log::error('[GitHub Webhook] For continuous deployment to work there must be an executable deploy.sh script in your project root.');
            abort(400, 'Configuration error. Please check the log.');
        }

        Log::info('[GitHub Webhook] Deploying changes from GitHub...');

        try {
            $result = Process::path(base_path())->run('./deploy.sh');
        } catch (Exception $e) {
            Log::error('[GitHub Webhook] Deployment exception: ' . $e->getMessage());
            return response('Deployment failed', 500);
        }

        if (!$result->successful()) {
            Log::info('[GitHub Webhook] Deployment output: ' . $result->output());
            Log::error('[GitHub Webhook] Deployment errors: ' . $result->errorOutput());
            return response('Deployment failed', 500);
        }

        Log::info('[GitHub Webhook] Deployment successful: ' . $result->output());
        return response('Deployment successful', 200);
    }
}
