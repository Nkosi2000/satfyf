<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Response as ResponseFacade;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

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
                fputcsv($handle, [static::csvSafe($subscriber->email), $subscriber->subscribed_at->toDateTimeString()]);
            }

            fclose($handle);
        }, 'newsletter-subscribers.csv');
    }

    /**
     * Guards against CSV/formula injection: a value starting with an equals
     * sign, plus, minus, at-sign, tab, or CR gets interpreted as a formula
     * by Excel/Sheets/etc. when the exported file is opened, rather than
     * displayed as plain text. A valid email can't actually start with any
     * of these, but this stays correct even if a less-strict field is ever
     * added to the export.
     */
    private static function csvSafe(string $value): string
    {
        return preg_match('/^[=+\-@\t\r]/', $value) === 1 ? "'".$value : $value;
    }

    public function destroy(NewsletterSubscriber $newsletterSubscriber): RedirectResponse
    {
        $newsletterSubscriber->delete();

        return redirect()->route('admin.newsletter-subscribers.index')->with('success', 'Subscriber removed.');
    }
}
