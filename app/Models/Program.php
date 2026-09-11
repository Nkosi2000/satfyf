<?php

namespace App\Models;

use App\Enums\ProgramCategory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['title', 'category', 'description', 'order', 'published'])]
class Program extends Model
{
    /** @use HasFactory<\Database\Factories\ProgramFactory> */
    use HasFactory, HasUuids;

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
}
