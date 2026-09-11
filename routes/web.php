<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\GetInvolvedController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\WhatWeDoController;
use App\Http\Controllers\WhoWeAreController;
use App\Http\Controllers\WhyWeExistController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/who-we-are', [WhoWeAreController::class, 'show'])->name('who-we-are');
Route::get('/why-we-exist', [WhyWeExistController::class, 'show'])->name('why-we-exist');
Route::get('/what-we-do', [WhatWeDoController::class, 'index'])->name('what-we-do');

Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('articles.show');

Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

Route::get('/resources', [ResourceController::class, 'index'])->name('resources.index');
Route::get('/resources/{resource}/download', [ResourceController::class, 'download'])->name('resources.download');

Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery');
Route::get('/partners', [PartnerController::class, 'index'])->name('partners');
Route::get('/get-involved', [GetInvolvedController::class, 'show'])->name('get-involved');

Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::post('/newsletter', [NewsletterController::class, 'store'])->name('newsletter.store');

require __DIR__.'/admin.php';
