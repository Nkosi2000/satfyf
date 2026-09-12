<?php

namespace App\Providers;

use App\Models\SiteSetting;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
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
        View::composer('components.footer', function ($view): void {
            $view->with('settings', [
                ...SiteSetting::group('contact'),
                ...SiteSetting::group('social'),
                ...SiteSetting::group('footer'),
            ]);
        });

        // SatfyfBot: generous enough for a real back-and-forth conversation,
        // tight enough to bound the cost of scripted abuse from a single IP.
        RateLimiter::for('chat', fn (Request $request) => [
            Limit::perMinute(15)->by($request->ip()),
            Limit::perHour(60)->by($request->ip()),
        ]);
    }
}
