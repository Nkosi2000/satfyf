<?php

namespace App\Models;

use App\Enums\PartnerType;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'logo_path', 'url', 'type', 'order', 'published'])]
class Partner extends Model
{
    /** @use HasFactory<\Database\Factories\PartnerFactory> */
    use HasFactory, HasUuids;

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
}
