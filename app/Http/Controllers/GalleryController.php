<?php

namespace App\Http\Controllers;

use App\Models\GalleryImage;
use App\Models\SiteSetting;
use Illuminate\View\View;

class GalleryController extends Controller
{
    public function index(): View
    {
        return view('pages.gallery', [
            'content' => SiteSetting::group('gallery_page'),
            'images' => GalleryImage::allOrdered(),
        ]);
    }
}
