<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function index(): View
    {
        return view('pages.articles.index', [
            'articles' => Article::query()->published()->latest('published_at')->paginate(9),
        ]);
    }

    public function show(Article $article): View
    {
        abort_unless($article->published_at?->isPast(), 404);

        return view('pages.articles.show', [
            'article' => $article,
            'related' => Article::query()
                ->published()
                ->whereKeyNot($article->id)
                ->latest('published_at')
                ->take(3)
                ->get(),
        ]);
    }

    public function attachment(Article $article): RedirectResponse
    {
        abort_unless($article->published_at?->isPast(), 404);
        abort_unless($article->attachment_path, 404);

        return redirect(Storage::disk('public')->url($article->attachment_path));
    }
}
