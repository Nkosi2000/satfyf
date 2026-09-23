<?php

namespace App\Models;

use App\Models\Concerns\Cacheable;
use App\Models\Concerns\HasTranslations;
use Database\Factories\ArticleFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

#[Fillable(['title', 'slug', 'excerpt', 'body', 'cover_image_path', 'attachment_path', 'attachment_name', 'author_name', 'published_at'])]
class Article extends Model
{
    /** @use HasFactory<ArticleFactory> */
    use Cacheable, HasFactory, HasTranslations, HasUuids;

    /**
     * @var array<int, string>
     */
    protected array $translatable = ['title', 'excerpt', 'body'];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * @param  Builder<Article>  $query
     * @return Builder<Article>
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->whereNotNull('published_at')->where('published_at', '<=', now());
    }

    public function renderedBody(): string
    {
        // html_input: 'strip' — CommonMark's default allows raw inline/
        // block HTML to pass straight through into the page (rendered
        // unescaped via {!! !!} in articles/show.blade.php). Article
        // bodies are only ever admin-authored today, but stripping this
        // means a compromised or careless admin account can't turn the
        // body field into a stored-XSS vector.
        return Str::markdown($this->body, ['html_input' => 'strip']);
    }

    /**
     * Gates the newspaper-column treatment in articles/show.blade.php to
     * pieces short enough to read in columns without the reader having to
     * scroll one column to its end and back up to start the next — real
     * multi-column text is a print-era pattern that only works on a
     * scrolling web page while the whole flowed block still fits on one
     * screen.
     */
    public function isShortForm(): bool
    {
        return str_word_count(strip_tags($this->renderedBody())) <= 220;
    }

    /**
     * Always returned in display order — there's no case where an
     * unordered list of an article's body images is useful, so the
     * ordering lives on the relationship itself rather than relying on
     * every call site to remember `->ordered()`.
     *
     * @return HasMany<ArticleImage, $this>
     */
    public function images(): HasMany
    {
        return $this->hasMany(ArticleImage::class)->orderBy('order');
    }

    /**
     * The home page's "latest articles" teaser was the single most
     * expensive query on that page — every other frequently-read,
     * admin-managed model here already uses Cacheable, this one just
     * hadn't. Short TTL (not forever), like EventItem::cachedUpcoming():
     * whether an article counts as "published" depends on wall-clock time
     * (a scheduled published_at ticking into the past), not just row
     * writes, so a save-triggered cache-forget alone can't catch that.
     *
     * @return Collection<int, Article>
     */
    public static function cachedRecent(): Collection
    {
        return static::rememberQuery(
            fn () => static::query()->published()->latest('published_at')->take(3)->get(),
            now()->addMinutes(5),
        );
    }

    protected static function cacheKey(): string
    {
        return 'articles.recent';
    }
}
