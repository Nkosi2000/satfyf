<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\FaqItemResource;
use App\Models\FaqItem;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class FaqItemController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return FaqItemResource::collection(FaqItem::publishedOrdered());
    }
}
