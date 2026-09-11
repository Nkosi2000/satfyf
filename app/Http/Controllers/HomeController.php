<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\EventItem;
use App\Models\FaqItem;
use App\Models\GalleryImage;
use App\Models\Partner;
use App\Models\Program;
use App\Models\SiteSetting;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        return view('pages.home', [
            'hero' => SiteSetting::group('hero'),
            'mission' => SiteSetting::group('mission'),
            'programs' => Program::query()->published()->ordered()->get()->groupBy(fn (Program $program) => $program->category->value),
            'articles' => Article::query()->published()->latest('published_at')->take(3)->get(),
            'events' => EventItem::query()->published()->upcoming()->take(3)->get(),
            'partners' => Partner::query()->published()->ordered()->get(),
            'faqs' => FaqItem::query()->published()->ordered()->get(),
            'galleryImages' => GalleryImage::query()->ordered()->take(10)->get(),
        ]);
    }
}
