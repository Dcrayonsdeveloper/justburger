<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Setting;
use App\Models\UserAddress;
use App\Support\PageCache;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        // Apply timezone from settings
        try {
            $timezone = Setting::get('timezone', config('app.timezone'));
            if ($timezone && in_array($timezone, timezone_identifiers_list())) {
                config(['app.timezone' => $timezone]);
                date_default_timezone_set($timezone);
            }
        } catch (\Exception $e) {
            // Settings table may not exist during migrations
        }

        Route::model('address', UserAddress::class);

        Blade::directive('price', function (string $expression) {
            return "<?php echo format_price({$expression}); ?>";
        });

        // @setting('key', 'default') — pull value from DB settings
        Blade::directive('setting', function (string $expression) {
            return "<?php echo \App\Models\Setting::get({$expression}); ?>";
        });

        // @currency — output currency symbol (e.g. £)
        Blade::directive('currency', function () {
            return "<?php echo currency_symbol(); ?>";
        });

        View::composer(['partials.mobile-nav', 'partials.header'], function ($view) {
            $view->with('navCategories', Category::whereNull('parent_id')
                ->where('is_active', true)
                ->with(['children' => fn ($q) => $q->where('is_active', true)->orderBy('position')])
                ->orderBy('position')
                ->get());
        });

        // Invalidate the full-page response cache whenever catalogue or business
        // data changes, so admin edits (add/edit/delete product, category, price,
        // settings) appear on the storefront immediately instead of after the TTL.
        $bustPageCache = fn () => PageCache::bump();
        Product::saved($bustPageCache);
        Product::deleted($bustPageCache);
        Product::restored($bustPageCache);
        Category::saved($bustPageCache);
        Category::deleted($bustPageCache);
        Setting::saved($bustPageCache);
    }
}
