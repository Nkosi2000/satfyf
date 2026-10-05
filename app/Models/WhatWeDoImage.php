<?php

namespace App\Models;

use App\Models\Concerns\Cacheable;
use Database\Factories\WhatWeDoImageFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * An image in the rotating slideshow beside the What We Do page's
 * milestone section. Kept separate from GalleryImage and GoalImage so each
 * slideshow is managed on its own and never shows up on the Gallery page.
 */
#[Fillable(['caption', 'image_path', 'order'])]
class WhatWeDoImage extends Model
{
    /** @use HasFactory<WhatWeDoImageFactory> */
    use Cacheable, HasFactory, HasUuids;

    protected function casts(): array
    {
        return [
            'order' => 'integer',
        ];
    }

    /**
     * @param  Builder<WhatWeDoImage>  $query
     * @return Builder<WhatWeDoImage>
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('order');
    }

    /**
     * @return Collection<int, WhatWeDoImage>
     */
    public static function allOrdered(): Collection
    {
        return static::rememberQuery(fn () => static::query()->ordered()->get());
    }

    protected static function cacheKey(): string
    {
        return 'what_we_do_images.ordered';
    }
}
