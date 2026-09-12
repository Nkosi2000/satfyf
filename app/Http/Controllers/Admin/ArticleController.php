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
        $data = $request->safe()->except(['cover_image', 'attachment']);

        if ($request->hasFile('cover_image')) {
            $data['cover_image_path'] = $request->file('cover_image')->store('articles', 'public');
        }

        if ($request->hasFile('attachment')) {
            $data['attachment_path'] = $request->file('attachment')->store('articles/attachments', 'public');
            $data['attachment_name'] = $request->file('attachment')->getClientOriginalName();
        }

        $article = Article::query()->create($data);

        return redirect()->route('admin.articles.edit', $article)->with('success', 'Article saved.');
    }

    public function edit(Article $article): View
    {
        return view('admin.articles.edit', [
            'article' => $article,
            'images' => $article->images,
        ]);
    }

    public function update(ArticleRequest $request, Article $article): RedirectResponse
    {
        $data = $request->safe()->except(['cover_image', 'attachment']);

        if ($request->hasFile('cover_image')) {
            if ($article->cover_image_path) {
                Storage::disk('public')->delete($article->cover_image_path);
            }

            $data['cover_image_path'] = $request->file('cover_image')->store('articles', 'public');
        }

        if ($request->hasFile('attachment')) {
            if ($article->attachment_path) {
                Storage::disk('public')->delete($article->attachment_path);
            }

            $data['attachment_path'] = $request->file('attachment')->store('articles/attachments', 'public');
            $data['attachment_name'] = $request->file('attachment')->getClientOriginalName();
        }

        $article->update($data);

        return redirect()->route('admin.articles.index')->with('success', 'Article updated.');
    }

    public function destroy(Article $article): RedirectResponse
    {
        if ($article->cover_image_path) {
            Storage::disk('public')->delete($article->cover_image_path);
        }

        if ($article->attachment_path) {
            Storage::disk('public')->delete($article->attachment_path);
        }

        Storage::disk('public')->delete($article->images()->pluck('image_path')->all());

        $article->delete();

        return redirect()->route('admin.articles.index')->with('success', 'Article removed.');
    }
}
