<?php

namespace App\Providers;

use App\Models\Setting;
use App\Models\User;
use App\Services\IconService;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(IconService::class, function ($app) {
            return new IconService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (app()->isLocal()) {
            Model::preventLazyLoading();
        }

        Relation::morphMap([
            'post' => 'App\Models\Post',
        ]);

        Password::defaults(function () {
            if (app()->isProduction()) {
                return Password::min(8)->mixedCase()->numbers();
            }

            return Password::min(8);
        });

        User::created(function ($user) {
            $user->assignRole('unverified');
        });

        Blade::directive('fuzzyDate', function (string $expression) {
            return "<?php echo App\Helpers\DateHelper::fuzzyDate($expression); ?>";
        });

        Blade::directive('xcloak', function ($condition) {
            return "<?php echo $condition ? 'x-cloak' : ''; ?>";
        });

        try {
            $settings = Cache::rememberForever('settings', function () {
                return Setting::all()->mapWithKeys(fn ($model) => [$model->key => $model->value])->all();
            });

            config(['settings' => $settings]);
        } catch (Exception) {}
    }
}
