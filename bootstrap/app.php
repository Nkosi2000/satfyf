<?php

use App\Http\Middleware\EnsureUserIsAdmin;
use App\Http\Middleware\PreventSessionHijacking;
use App\Http\Middleware\SetLocale;
use App\Http\Middleware\SignOutIdleSessions;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withSchedule(function (Schedule $schedule): void {
        // Well inside storage_url()'s 5h30m cache TTL (app/helpers.php) —
        // keeps every signed URL refreshed before it expires so a real
        // request never pays Neon Storage's ~1s-per-call signing cost.
        $schedule->command('app:warm-storage-urls')->hourly();
    })
    ->withMiddleware(function (Middleware $middleware): void {
        // Railway (and every other PaaS this could run on) terminates TLS at
        // its edge and forwards plain HTTP to the container — the container
        // is never reachable directly, so trusting the immediate proxy is
        // safe. Without this, url()/route() generate http:// links even on
        // an https:// site (Laravel only trusts X-Forwarded-Proto from a
        // trusted proxy), which is why the cookie-consent form and other
        // generated URLs came back as http:// on the deployed site.
        $middleware->trustProxies(at: '*');

        $middleware->alias([
            'admin' => EnsureUserIsAdmin::class,
            'locale' => SetLocale::class,
            'session.fingerprint' => PreventSessionHijacking::class,
            'session.idle' => SignOutIdleSessions::class,
        ]);

        $middleware->redirectGuestsTo(fn (Request $request) => route('admin.login'));

        $middleware->throttleApi();
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })->create();
