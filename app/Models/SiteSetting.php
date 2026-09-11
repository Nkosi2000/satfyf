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
        $row = static::allRows()->firstWhere('key', $key);

        return $row === null ? $default : (static::resolveValue($row['value']) ?? $default);
    }

    /**
     * @return array<string, string>
     */
    public static function group(string $group): array
    {
        return static::allRows()
            ->where('group', $group)
            ->mapWithKeys(fn (array $row) => [$row['key'] => static::resolveValue($row['value'])])
            ->all();
    }

    /**
     * Decode a raw {"en": ..., "zu": ...} JSON value and resolve it against
     * the current request's locale. Done by hand (not via the shared
     * Translatable cast) because allRows() caches plain, un-cast arrays —
     * casting here would bake one locale into a cache shared by every
     * visitor. See the class-level caching note below.
     */
    protected static function resolveValue(?string $raw): ?string
    {
        if ($raw === null) {
            return null;
        }

        $decoded = json_decode($raw, true);

        if (! is_array($decoded)) {
            return $raw;
        }

        $locale = app()->getLocale();
        $fallback = config('app.fallback_locale');

        return $decoded[$locale] ?? $decoded[$fallback] ?? null;
    }

    /**
     * The raw, un-resolved per-locale values for this setting — used by the
     * admin settings form to prefill all 4 locale inputs at once.
     *
     * @return array<string, string>
     */
    public function translations(): array
    {
        if ($this->value === null) {
            return [];
        }

        $decoded = json_decode($this->value, true);

        return is_array($decoded) ? $decoded : [];
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
