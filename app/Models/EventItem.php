<?php

namespace App\Models;

use App\Models\Concerns\Cacheable;
use App\Models\Concerns\HasTranslations;
use Database\Factories\EventItemFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

#[Fillable(['title', 'slug', 'description', 'location', 'starts_at', 'ends_at', 'cover_image_path', 'is_featured', 'published'])]
class EventItem extends Model
{
    /** @use HasFactory<EventItemFactory> */
    use Cacheable, HasFactory, HasTranslations, HasUuids;

    /**
     * @var array<int, string>
     */
    protected array $translatable = ['title', 'description', 'location'];

    protected function casts(): array
    {
        return [
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
            'is_featured' => 'boolean',
            'published' => 'boolean',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * @param  Builder<EventItem>  $query
     * @return Builder<EventItem>
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('published', true);
    }

    /**
     * @param  Builder<EventItem>  $query
     * @return Builder<EventItem>
     */
    public function scopeUpcoming(Builder $query): Builder
    {
        return $query->where('starts_at', '>=', now())->orderBy('starts_at');
    }

    /**
     * @param  Builder<EventItem>  $query
     * @return Builder<EventItem>
     */
    public function scopePast(Builder $query): Builder
    {
        return $query->where('starts_at', '<', now())->orderByDesc('starts_at');
    }

    public function isUpcoming(): bool
    {
        return $this->starts_at->isFuture();
    }

    /**
     * Cached with a short TTL rather than forever — unlike the other
     * cached listings, membership here depends on wall-clock time, not
     * just row writes, so an edit-triggered cache-forget alone can't
     * catch an event ticking from upcoming to past.
     *
     * @return Collection<int, EventItem>
     */
    public static function cachedUpcoming(): Collection
    {
        return static::rememberQuery(
            fn () => static::query()->published()->upcoming()->get(),
            now()->addMinutes(5),
        );
    }

    protected static function cacheKey(): string
    {
        return 'event_items.upcoming';
    }
}
