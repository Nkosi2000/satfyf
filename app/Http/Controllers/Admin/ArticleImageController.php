<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArticleImageController extends Controller
{
    public function store(Request $request, Article $article): RedirectResponse
    {
        $request->validate([
            'images' => ['required', 'array'],
            'images.*' => ['image', 'max:8192'],
        ]);

        $nextOrder = (int) $article->images()->max('order') + 1;

        foreach ($request->file('images') as $image) {
            $article->images()->create([
                'image_path' => $image->store('articles/images', 'public'),
                'order' => $nextOrder++,
            ]);
        }

        return redirect()->route('admin.articles.edit', $article)->with('success', 'Images added.');
    }

    public function destroy(Article $article, ArticleImage $image): RedirectResponse
    {
        abort_unless($image->article_id === $article->id, 404);

        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return redirect()->route('admin.articles.edit', $article)->with('success', 'Image removed.');
    }
}
