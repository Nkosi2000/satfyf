<?php

namespace App\Models;

use Database\Factories\SiteSettingFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

#[Fillable(['group', 'key', 'value'])]
class SiteSetting extends Model
{
    /** @use HasFactory<SiteSettingFactory> */
    use HasFactory, HasUuids;

    public static function get(string $key, ?string $default = null): ?string
    {
        return static::allRows()->firstWhere('key', $key)['value'] ?? $default;
    }

    /**
     * @return array<string, string>
     */
    public static function group(string $group): array
    {
        return static::allRows()
            ->where('group', $group)
            ->pluck('value', 'key')
            ->all();
    }

    public static function forgetCache(): void
    {
        static::$cached = null;
        Cache::forget('site_settings.all_rows');
    }

    /**
     * Rows for the current request, fetched once and reused by every
     * get()/group() call so a single page render costs one query instead
     * of one per settings group — each round trip is expensive here since
     * the app's DB and cache store both live on a remote Postgres.
     *
     * Cached as plain arrays rather than Eloquent models: the database
     * cache driver serializes values, and Eloquent model instances don't
     * survive that round trip reliably.
     *
     * @return Collection<int, array{group: string, key: string, value: ?string}>
     */
    protected static function allRows(): Collection
    {
        return static::$cached ??= collect(Cache::rememberForever(
            'site_settings.all_rows',
            fn () => static::query()->get(['group', 'key', 'value'])->toArray(),
        ));
    }

    /**
     * @var Collection<int, array{group: string, key: string, value: ?string}>|null
     */
    protected static ?Collection $cached = null;

    protected static function booted(): void
    {
        static::saved(fn () => static::forgetCache());
        static::deleted(fn () => static::forgetCache());
    }
}
