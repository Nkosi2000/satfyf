<?php

use App\Http\Controllers\Api\V1\ArticleController;
use App\Http\Controllers\Api\V1\EventController;
use App\Http\Controllers\Api\V1\FaqItemController;
use App\Http\Controllers\Api\V1\GalleryImageController;
use App\Http\Controllers\Api\V1\PartnerController;
use App\Http\Controllers\Api\V1\ResourceController;
use App\Http\Controllers\Api\V1\TeamMemberController;
use App\Http\Controllers\Api\V1\TestimonialController;
use Illuminate\Support\Facades\Route;

/*
 * Public, read-only JSON API over the same published/ordered content the
 * website itself shows — no auth, since none of this is behind a login on
 * the site either. Versioned under /api/v1 up front so a future breaking
 * change (renaming a field, changing pagination) doesn't force every
 * consumer to update at once.
 */
Route::prefix('v1')->name('api.v1.')->group(function (): void {
    Route::get('articles', [ArticleController::class, 'index'])->name('articles.index');
    Route::get('articles/{article:slug}', [ArticleController::class, 'show'])->name('articles.show');

    Route::get('events', [EventController::class, 'index'])->name('events.index');
    Route::get('events/{event:slug}', [EventController::class, 'show'])->name('events.show');

    Route::get('gallery-images', [GalleryImageController::class, 'index'])->name('gallery-images.index');
    Route::get('resources', [ResourceController::class, 'index'])->name('resources.index');
    Route::get('team-members', [TeamMemberController::class, 'index'])->name('team-members.index');
    Route::get('partners', [PartnerController::class, 'index'])->name('partners.index');
    Route::get('testimonials', [TestimonialController::class, 'index'])->name('testimonials.index');
    Route::get('faqs', [FaqItemController::class, 'index'])->name('faqs.index');
});
