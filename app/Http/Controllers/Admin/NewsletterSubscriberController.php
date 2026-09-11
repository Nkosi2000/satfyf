<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Response as ResponseFacade;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\View\View;

class NewsletterSubscriberController extends Controller
{
    public function index(): View
    {
        return view('admin.newsletter-subscribers.index', [
            'subscribers' => NewsletterSubscriber::query()->latest('subscribed_at')->paginate(30),
        ]);
    }

    public function export(): StreamedResponse
    {
        $subscribers = NewsletterSubscriber::query()->orderBy('subscribed_at')->get();

        return ResponseFacade::streamDownload(function () use ($subscribers): void {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Email', 'Subscribed At']);

            foreach ($subscribers as $subscriber) {
                fputcsv($handle, [$subscriber->email, $subscriber->subscribed_at->toDateTimeString()]);
            }

            fclose($handle);
        }, 'newsletter-subscribers.csv');
    }

    public function destroy(NewsletterSubscriber $newsletterSubscriber): RedirectResponse
    {
        $newsletterSubscriber->delete();

        return redirect()->route('admin.newsletter-subscribers.index')->with('success', 'Subscriber removed.');
    }
}
