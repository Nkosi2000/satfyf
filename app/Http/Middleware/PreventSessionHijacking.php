<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Binds an authenticated admin session to the IP + User-Agent it was
 * created under (AuthenticatedSessionController stores the fingerprint on
 * login). If a request later arrives with a different fingerprint on that
 * same session — the signature of a stolen/replayed session cookie — the
 * session is torn down and the user is sent back to sign in, rather than
 * letting the request through as whoever holds the cookie.
 *
 * This app has a small, trusted set of admin users, so the cost of an
 * occasional false positive (an ISP rotating a public IP mid-session) is
 * worth it for the anti-hijacking guarantee.
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
        return hash('sha256', $request->ip().'|'.$request->userAgent());
    }
}
