<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Signs an admin out once they've gone longer than IDLE_TIMEOUT_MINUTES
 * without making a request. Scoped to the admin area on purpose — the
 * global SESSION_LIFETIME also carries public visitors' language choice,
 * which shouldn't reset after a few idle minutes.
 */
class SignOutIdleSessions
{
    public const IDLE_TIMEOUT_MINUTES = 5;

    private const LAST_ACTIVITY_KEY = 'admin_last_activity_at';

    /**
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $lastActivityAt = $request->session()->get(self::LAST_ACTIVITY_KEY);

        if ($lastActivityAt !== null && now()->timestamp - $lastActivityAt > self::IDLE_TIMEOUT_MINUTES * 60) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route('admin.login')
                ->withErrors(['email' => 'You were signed out after '.self::IDLE_TIMEOUT_MINUTES.' minutes of inactivity.']);
        }

        $request->session()->put(self::LAST_ACTIVITY_KEY, now()->timestamp);

        return $next($request);
    }
}
