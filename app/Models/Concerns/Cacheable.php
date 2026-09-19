<?php

namespace App\Models\Concerns;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

/**
 * Caches a model's full result set, invalidating on any save or delete.
 * Used by small, admin-managed tables that are read far more often than
 * they change.
 *
 * Caches raw attribute arrays and rehydrates models on every read, rather
 * than caching the Collection of models directly — this app's cache config
 * sets `serializable_classes` to false (a deliberate guard against object-
 * injection gadget chains if APP_KEY leaks), so `unserialize()` refuses to
 * reconstruct any object and a cached Collection of models comes back as
 * `__PHP_Incomplete_Class` instead. Raw arrays sidestep that entirely, and
 * rehydrating also means casts (e.g. Translatable) resolve fresh against
 * the current request's locale instead of being baked in at cache-write
 * time — see SiteSetting::resolveValue() for the same concern.
 */
trait Cacheable
{
    protected static function bootCacheable(): void
    {
        static::saved(fn () => Cache::forget(static::cacheKey()));
        static::deleted(fn () => Cache::forget(static::cacheKey()));
    }

    abstract protected static function cacheKey(): string;

    /**
     * @param  callable(): Collection<int, static>  $query
     * @param  \DateInterval|\DateTimeInterface|int|null  $ttl  Null caches forever.
     * @return Collection<int, static>
     */
    protected static function rememberQuery(callable $query, \DateInterval|\DateTimeInterface|int|null $ttl = null): Collection
    {
        $toRows = fn () => $query()->map(fn (self $model) => $model->getAttributes())->all();

        $rows = $ttl === null
            ? Cache::rememberForever(static::cacheKey(), $toRows)
            : Cache::remember(static::cacheKey(), $ttl, $toRows);

        return static::hydrate($rows);
    }
}
