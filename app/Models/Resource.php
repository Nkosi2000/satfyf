<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['title', 'description', 'file_path', 'category', 'published'])]
class Resource extends Model
{
    /** @use HasFactory<\Database\Factories\ResourceFactory> */
    use HasFactory, HasUuids;

    protected function casts(): array
    {
        return [
            'published' => 'boolean',
        ];
    }

    /**
     * @param  Builder<Resource>  $query
     * @return Builder<Resource>
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('published', true);
    }
}
