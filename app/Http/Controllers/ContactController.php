<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactSubmissionRequest;
use App\Models\ContactSubmission;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function show(): View
    {
        return view('pages.contact', [
            'contact' => SiteSetting::group('contact'),
        ]);
    }

    public function store(StoreContactSubmissionRequest $request): RedirectResponse
    {
        ContactSubmission::query()->create($request->validated());

        return back()->with('contact_success', __('Thanks for reaching out — we\'ll get back to you soon.'));
    }
}
