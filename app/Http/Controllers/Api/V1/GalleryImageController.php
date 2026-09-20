<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\GalleryImageResource;
use App\Models\GalleryImage;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GalleryImageController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return GalleryImageResource::collection(GalleryImage::allOrdered());
    }
}
