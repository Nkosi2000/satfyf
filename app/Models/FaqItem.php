<?php

namespace App\Models;

use App\Models\Concerns\Cacheable;
use App\Models\Concerns\HasTranslations;
use Database\Factories\FaqItemFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

#[Fillable(['question', 'answer', 'order', 'published'])]
class FaqItem extends Model
{
    /** @use HasFactory<FaqItemFactory> */
    use Cacheable, HasFactory, HasTranslations, HasUuids;

    /**
     * @var array<int, string>
     */
    protected array $translatable = ['question', 'answer'];

    protected function casts(): array
    {
        return [
            'published' => 'boolean',
            'order' => 'integer',
        ];
    }

    /**
     * @param  Builder<FaqItem>  $query
     * @return Builder<FaqItem>
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('published', true);
    }

    /**
     * @param  Builder<FaqItem>  $query
     * @return Builder<FaqItem>
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('order');
    }

    /**
     * @return Collection<int, FaqItem>
     */
    public static function publishedOrdered(): Collection
    {
        return static::rememberQuery(fn () => static::query()->published()->ordered()->get());
    }

    protected static function cacheKey(): string
    {
        return 'faq_items.published_ordered';
    }
}
