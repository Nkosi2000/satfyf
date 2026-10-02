<?php

namespace App\Models;

use App\Models\Concerns\Cacheable;
use Database\Factories\ProvinceFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * A province listed under the Who We Are page's "Youth Chapters" section.
 * Replaced the four fixed youth_chapters_province_N site settings so admins
 * can list any number of provinces.
 */
#[Fillable(['name', 'order'])]
class Province extends Model
{
    /** @use HasFactory<ProvinceFactory> */
    use Cacheable, HasFactory, HasUuids;

    protected function casts(): array
    {
        return [
            'order' => 'integer',
        ];
    }

    /**
     * @param  Builder<Province>  $query
     * @return Builder<Province>
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('order')->orderBy('name');
    }

    /**
     * @return Collection<int, Province>
     */
    public static function allOrdered(): Collection
    {
        return static::rememberQuery(fn () => static::query()->ordered()->get());
    }

    protected static function cacheKey(): string
    {
        return 'provinces.ordered';
    }
}
