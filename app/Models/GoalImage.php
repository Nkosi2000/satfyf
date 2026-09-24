<?php

namespace App\Models;

use App\Models\Concerns\Cacheable;
use Database\Factories\GoalImageFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * An image in the rotating slideshow beside the Who We Are page's
 * "Goals & Objectives" section. Kept separate from GalleryImage so these
 * never show up on the public Gallery page.
 */
#[Fillable(['caption', 'image_path', 'order'])]
class GoalImage extends Model
{
    /** @use HasFactory<GoalImageFactory> */
    use Cacheable, HasFactory, HasUuids;

    protected function casts(): array
    {
        return [
            'order' => 'integer',
        ];
    }

    /**
     * @param  Builder<GoalImage>  $query
     * @return Builder<GoalImage>
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('order');
    }

    /**
     * @return Collection<int, GoalImage>
     */
    public static function allOrdered(): Collection
    {
        return static::rememberQuery(fn () => static::query()->ordered()->get());
    }

    protected static function cacheKey(): string
    {
        return 'goal_images.ordered';
    }
}
