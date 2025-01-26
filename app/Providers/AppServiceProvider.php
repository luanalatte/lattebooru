<?php

namespace App\Providers;

use App\Models\Post;
use App\Models\Scopes\VisibleScope;
use App\Models\User;
use App\Services\IconService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
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
            $user->assignRole('user');
        });

        Route::bind('post', function ($value) {
            return Post::withoutGlobalScopes([VisibleScope::class])->findOrFail($value);
        });

        Blade::directive('fuzzyDate', function (string $expression) {
            return "<?php echo App\Helpers\DateHelper::fuzzyDate($expression); ?>";
        });
    }
}
