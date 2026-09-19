<?php

namespace App\Models;

use App\Enums\PartnerType;
use App\Models\Concerns\Cacheable;
use Database\Factories\PartnerFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

#[Fillable(['name', 'logo_path', 'url', 'type', 'order', 'published'])]
class Partner extends Model
{
    /** @use HasFactory<PartnerFactory> */
    use Cacheable, HasFactory, HasUuids;

    protected function casts(): array
    {
        return [
            'type' => PartnerType::class,
            'published' => 'boolean',
            'order' => 'integer',
        ];
    }

    /**
     * @param  Builder<Partner>  $query
     * @return Builder<Partner>
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('published', true);
    }

    /**
     * @param  Builder<Partner>  $query
     * @return Builder<Partner>
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('order');
    }

    /**
     * @return Collection<int, Partner>
     */
    public static function publishedOrdered(): Collection
    {
        return static::rememberQuery(fn () => static::query()->published()->ordered()->get());
    }

    protected static function cacheKey(): string
    {
        return 'partners.published_ordered';
    }
}
