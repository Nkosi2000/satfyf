<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

#[Fillable(['group', 'key', 'value'])]
class SiteSetting extends Model
{
    /** @use HasFactory<\Database\Factories\SiteSettingFactory> */
    use HasFactory, HasUuids;

    public static function get(string $key, ?string $default = null): ?string
    {
        return static::allByKey()->get($key, $default);
    }

    /**
     * @return array<string, string>
     */
    public static function group(string $group): array
    {
        return static::query()
            ->where('group', $group)
            ->pluck('value', 'key')
            ->all();
    }

    public static function forgetCache(): void
    {
        Cache::forget('site_settings.by_key');
    }

    /**
     * @return \Illuminate\Support\Collection<string, ?string>
     */
    protected static function allByKey(): \Illuminate\Support\Collection
    {
        return Cache::rememberForever(
            'site_settings.by_key',
            fn () => static::query()->pluck('value', 'key'),
        );
    }

    protected static function booted(): void
    {
        static::saved(fn () => static::forgetCache());
        static::deleted(fn () => static::forgetCache());
    }
}
