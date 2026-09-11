<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Database\Factories\ResourceFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['title', 'description', 'file_path', 'category', 'published'])]
class Resource extends Model
{
    /** @use HasFactory<ResourceFactory> */
    use HasFactory, HasTranslations, HasUuids;

    /**
     * @var array<int, string>
     */
    protected array $translatable = ['title', 'description', 'category'];

    protected function casts(): array
    {
        return [
            'published' => 'boolean',
        ];
    }

    /**
     * @param  Builder<resource>  $query
     * @return Builder<resource>
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('published', true);
    }
}
