<?php

namespace App\Providers;

use App\Models\Post;
use App\Models\Scopes\VisibleScope;
use Illuminate\Database\Eloquent\Model;
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
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (app()->isLocal()) {
            Model::preventLazyLoading();
        }

        Password::defaults(function () {
            if (app()->isProduction()) {
                return Password::min(8)->mixedCase()->numbers();
            }

            return Password::min(8);
        });

        Route::bind('post', function ($value) {
            return Post::withoutGlobalScopes([VisibleScope::class])->findOrFail($value);
        });

        Blade::directive('fuzzyDate', function (string $expression) {
            return "<?php echo App\Helpers\DateHelper::fuzzyDate($expression); ?>";
        });
    }
}
