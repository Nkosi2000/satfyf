<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Binds an authenticated admin session to the User-Agent it was created
 * under (AuthenticatedSessionController stores the fingerprint on login).
 * If a request later arrives with a different fingerprint on that same
 * session — the signature of a stolen/replayed session cookie — the session
 * is torn down and the user is sent back to sign in, rather than letting
 * the request through as whoever holds the cookie.
 *
 * The IP is deliberately left out: browsers alternate between IPv4 and
 * IPv6, and mobile/Wi-Fi hand-offs change it mid-session, which signed
 * admins out every few minutes in production. SignOutIdleSessions covers
 * the "walked away from an open session" case instead.
 */
class PreventSessionHijacking
{
    /**
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $stored = $request->session()->get('auth_fingerprint');
        $current = static::fingerprint($request);

        if ($stored !== null && $stored !== $current) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route('admin.login')
                ->withErrors(['email' => 'Your session was signed out for security — the request no longer matched the browser it started in.']);
        }

        return $next($request);
    }

    public static function fingerprint(Request $request): string
    {
        return hash('sha256', (string) $request->userAgent());
    }
}
