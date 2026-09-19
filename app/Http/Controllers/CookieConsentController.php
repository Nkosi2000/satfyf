<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;

class CookieConsentController extends Controller
{
    /**
     * Records consent as an actual first-party cookie (mirrors how
     * SetLocaleController persists the chosen language) rather than a
     * client-side localStorage flag — the banner itself checks this same
     * cookie server-side, so it never renders at all once set, with or
     * without JavaScript.
     */
    public function store(): RedirectResponse
    {
        return back()->withCookie(
            cookie('cookie_consent', 'accepted', 60 * 24 * 365),
        );
    }
}
