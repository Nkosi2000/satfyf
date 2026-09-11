<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Database\Factories\EventItemFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['title', 'slug', 'description', 'location', 'starts_at', 'ends_at', 'cover_image_path', 'is_featured', 'published'])]
class EventItem extends Model
{
    /** @use HasFactory<EventItemFactory> */
    use HasFactory, HasTranslations, HasUuids;

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
}
