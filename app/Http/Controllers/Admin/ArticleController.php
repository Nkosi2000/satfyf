<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ArticleRequest;
use App\Models\Article;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function index(): View
    {
        return view('admin.articles.index', [
            'articles' => Article::query()->latest('published_at')->paginate(20),
        ]);
    }

    public function create(): View
    {
        return view('admin.articles.create');
    }

    public function store(ArticleRequest $request): RedirectResponse
    {
        $data = $request->safe()->except('cover_image');

        if ($request->hasFile('cover_image')) {
            $data['cover_image_path'] = $request->file('cover_image')->store('articles', 'public');
        }

        Article::query()->create($data);

        return redirect()->route('admin.articles.index')->with('success', 'Article saved.');
    }

    public function edit(Article $article): View
    {
        return view('admin.articles.edit', ['article' => $article]);
    }

    public function update(ArticleRequest $request, Article $article): RedirectResponse
    {
        $data = $request->safe()->except('cover_image');

        if ($request->hasFile('cover_image')) {
            if ($article->cover_image_path) {
                Storage::disk('public')->delete($article->cover_image_path);
            }

            $data['cover_image_path'] = $request->file('cover_image')->store('articles', 'public');
        }

        $article->update($data);

        return redirect()->route('admin.articles.index')->with('success', 'Article updated.');
    }

    public function destroy(Article $article): RedirectResponse
    {
        if ($article->cover_image_path) {
            Storage::disk('public')->delete($article->cover_image_path);
        }

        $article->delete();

        return redirect()->route('admin.articles.index')->with('success', 'Article removed.');
    }
}
