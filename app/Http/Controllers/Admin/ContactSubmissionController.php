<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactSubmission;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ContactSubmissionController extends Controller
{
    public function index(): View
    {
        return view('admin.contact-submissions.index', [
            'submissions' => ContactSubmission::query()->latest()->paginate(20),
        ]);
    }

    public function show(ContactSubmission $contactSubmission): View
    {
        if (! $contactSubmission->is_read) {
            $contactSubmission->update(['is_read' => true]);
        }

        return view('admin.contact-submissions.show', ['submission' => $contactSubmission]);
    }

    public function destroy(ContactSubmission $contactSubmission): RedirectResponse
    {
        $contactSubmission->delete();

        return redirect()->route('admin.contact-submissions.index')->with('success', 'Submission deleted.');
    }
}
