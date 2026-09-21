<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    public function create(): View
    {
        return view('admin.auth.forgot-password');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate(['email' => ['required', 'email']]);

        // Deliberately the same response whether or not the address is a
        // registered admin — confirming/denying account existence here
        // would let an attacker enumerate valid admin emails.
        Password::sendResetLink($request->only('email'));

        return back()->with('status', 'If that email belongs to an admin account, a password reset link is on its way.');
    }
}
