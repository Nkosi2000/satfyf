<?php

use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\AuthenticatedSessionController;
use App\Http\Controllers\Admin\ContactSubmissionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventItemController;
use App\Http\Controllers\Admin\FaqItemController;
use App\Http\Controllers\Admin\GalleryImageController;
use App\Http\Controllers\Admin\MarkdownPreviewController;
use App\Http\Controllers\Admin\NewsletterSubscriberController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\ProgramController;
use App\Http\Controllers\Admin\ResourceController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\Admin\TeamMemberController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->group(function (): void {
    Route::middleware('guest')->group(function (): void {
        Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
        Route::post('login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
    });

    Route::middleware(['auth', 'admin'])->group(function (): void {
        Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::post('markdown-preview', [MarkdownPreviewController::class, 'store'])->name('markdown-preview');

        Route::resource('team-members', TeamMemberController::class)->except('show');
        Route::resource('programs', ProgramController::class)->except('show');
        Route::resource('articles', ArticleController::class)->except('show');
        Route::resource('events', EventItemController::class)->except('show');
        Route::resource('resources', ResourceController::class)->except('show');
        Route::resource('gallery-images', GalleryImageController::class)->except('show');
        Route::resource('partners', PartnerController::class)->except('show');
        Route::resource('faqs', FaqItemController::class)->except('show');

        Route::get('contact-submissions', [ContactSubmissionController::class, 'index'])->name('contact-submissions.index');
        Route::get('contact-submissions/{contactSubmission}', [ContactSubmissionController::class, 'show'])->name('contact-submissions.show');
        Route::delete('contact-submissions/{contactSubmission}', [ContactSubmissionController::class, 'destroy'])->name('contact-submissions.destroy');

        Route::get('newsletter-subscribers', [NewsletterSubscriberController::class, 'index'])->name('newsletter-subscribers.index');
        Route::get('newsletter-subscribers/export', [NewsletterSubscriberController::class, 'export'])->name('newsletter-subscribers.export');
        Route::delete('newsletter-subscribers/{newsletterSubscriber}', [NewsletterSubscriberController::class, 'destroy'])->name('newsletter-subscribers.destroy');

        Route::get('settings', [SiteSettingController::class, 'edit'])->name('settings.edit');
        Route::put('settings', [SiteSettingController::class, 'update'])->name('settings.update');
    });
});
