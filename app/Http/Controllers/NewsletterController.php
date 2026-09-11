<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNewsletterSubscriberRequest;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\RedirectResponse;

class NewsletterController extends Controller
{
    public function store(StoreNewsletterSubscriberRequest $request): RedirectResponse
    {
        NewsletterSubscriber::query()->create([
            'email' => $request->validated('email'),
            'subscribed_at' => now(),
        ]);

        return back()->with('newsletter_success', __('You\'re subscribed. Thanks for joining us.'));
    }
}
