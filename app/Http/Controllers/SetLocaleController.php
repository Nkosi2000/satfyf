<?php

namespace App\Http\Controllers;

use App\Http\Middleware\SetLocale;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SetLocaleController extends Controller
{
    /**
     * Store the visitor's chosen language and return to where they were.
     */
    public function __invoke(Request $request, string $locale): RedirectResponse
    {
        abort_unless(in_array($locale, SetLocale::SUPPORTED, true), 404);

        $request->session()->put('locale', $locale);

        return redirect()->back()->withCookie(
            cookie('locale', $locale, 60 * 24 * 365),
        );
    }
}
