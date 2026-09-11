<?php

namespace App\Http\Controllers;

use App\Models\GalleryImage;
use Illuminate\View\View;

class GalleryController extends Controller
{
    public function index(): View
    {
        return view('pages.gallery', [
            'images' => GalleryImage::query()->ordered()->get(),
        ]);
    }
}
