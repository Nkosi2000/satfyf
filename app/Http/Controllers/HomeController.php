<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\EventItem;
use App\Models\FaqItem;
use App\Models\GalleryImage;
use App\Models\Partner;
use App\Models\Program;
use App\Models\SiteSetting;
use App\Models\Testimonial;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        return view('pages.home', [
            'hero' => SiteSetting::group('hero'),
            'mission' => SiteSetting::group('mission'),
            'programs' => Program::publishedOrdered()->groupBy(fn (Program $program) => $program->category->value),
            'articles' => Article::query()->published()->latest('published_at')->take(3)->get(),
            'events' => EventItem::cachedUpcoming()->take(3),
            'partners' => Partner::publishedOrdered(),
            'faqs' => FaqItem::publishedOrdered(),
            'galleryImages' => GalleryImage::allOrdered()->take(10),
            'testimonials' => Testimonial::publishedOrdered(),
        ]);
    }
}
