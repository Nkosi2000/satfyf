<?php

namespace App\Http\Resources;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Article
 */
class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'title' => $this->title,
            'excerpt' => $this->excerpt,
            'body_html' => $this->renderedBody(),
            'author_name' => $this->author_name,
            'cover_image_url' => storage_url($this->cover_image_path),
            'attachment' => $this->attachment_path ? [
                'name' => $this->attachment_name,
                'url' => route('articles.attachment', $this->resource),
            ] : null,
            'published_at' => $this->published_at?->toIso8601String(),
        ];
    }
}
