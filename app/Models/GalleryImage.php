<?php

namespace App\Models;

use App\Models\Concerns\Cacheable;
use Database\Factories\GalleryImageFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

#[Fillable(['caption', 'image_path', 'category', 'order'])]
class GalleryImage extends Model
{
    /** @use HasFactory<GalleryImageFactory> */
    use Cacheable, HasFactory, HasUuids;

    protected function casts(): array
    {
        return [
            'order' => 'integer',
        ];
    }

    /**
     * @param  Builder<GalleryImage>  $query
     * @return Builder<GalleryImage>
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('order');
    }

    /**
     * @return Collection<int, GalleryImage>
     */
    public static function allOrdered(): Collection
    {
        return static::rememberQuery(fn () => static::query()->ordered()->get());
    }

    protected static function cacheKey(): string
    {
        return 'gallery_images.ordered';
    }
}
