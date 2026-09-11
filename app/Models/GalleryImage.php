<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['caption', 'image_path', 'category', 'order'])]
class GalleryImage extends Model
{
    /** @use HasFactory<\Database\Factories\GalleryImageFactory> */
    use HasFactory, HasUuids;

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
}
