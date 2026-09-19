<?php

namespace App\Models;

use App\Enums\ProgramCategory;
use App\Models\Concerns\Cacheable;
use App\Models\Concerns\HasTranslations;
use Database\Factories\ProgramFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

#[Fillable(['title', 'category', 'description', 'order', 'published'])]
class Program extends Model
{
    /** @use HasFactory<ProgramFactory> */
    use Cacheable, HasFactory, HasTranslations, HasUuids;

    /**
     * @var array<int, string>
     */
    protected array $translatable = ['title', 'description'];

    protected function casts(): array
    {
        return [
            'category' => ProgramCategory::class,
            'published' => 'boolean',
            'order' => 'integer',
        ];
    }

    /**
     * @param  Builder<Program>  $query
     * @return Builder<Program>
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('published', true);
    }

    /**
     * @param  Builder<Program>  $query
     * @return Builder<Program>
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('order');
    }

    /**
     * @return Collection<int, Program>
     */
    public static function publishedOrdered(): Collection
    {
        return static::rememberQuery(fn () => static::query()->published()->ordered()->get());
    }

    protected static function cacheKey(): string
    {
        return 'programs.published_ordered';
    }
}
