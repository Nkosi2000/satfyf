<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ArticleController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return ArticleResource::collection(
            Article::query()->published()->latest('published_at')->paginate(12),
        );
    }

    public function show(Article $article): ArticleResource
    {
        abort_unless($article->published_at?->isPast(), 404);

        return new ArticleResource($article);
    }
}
