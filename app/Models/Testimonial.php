<?php

namespace App\Models;

use App\Models\Concerns\Cacheable;
use App\Models\Concerns\HasTranslations;
use Database\Factories\TestimonialFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

#[Fillable(['name', 'role', 'quote', 'photo_path', 'order', 'published'])]
class Testimonial extends Model
{
    /** @use HasFactory<TestimonialFactory> */
    use Cacheable, HasFactory, HasTranslations, HasUuids;

    /**
     * @var array<int, string>
     */
    protected array $translatable = ['quote'];

    protected function casts(): array
    {
        return [
            'published' => 'boolean',
            'order' => 'integer',
        ];
    }

    /**
     * @param  Builder<Testimonial>  $query
     * @return Builder<Testimonial>
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('published', true);
    }

    /**
     * @param  Builder<Testimonial>  $query
     * @return Builder<Testimonial>
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('order');
    }

    /**
     * @return Collection<int, Testimonial>
     */
    public static function publishedOrdered(): Collection
    {
        return static::rememberQuery(fn () => static::query()->published()->ordered()->get());
    }

    protected static function cacheKey(): string
    {
        return 'testimonials.published_ordered';
    }
}
