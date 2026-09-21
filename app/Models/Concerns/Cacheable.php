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
        static::saved(fn () => static::forgetCacheSafely());
        static::deleted(fn () => static::forgetCacheSafely());
    }

    abstract protected static function cacheKey(): string;

    /**
     * A degraded/unreachable Redis must never turn a successful save or
     * delete into a 500 — the row is already committed by this point,
     * dropping the invalidation just means the next read serves a stale
     * cached value for one TTL cycle instead of failing the request.
     */
    private static function forgetCacheSafely(): void
    {
        try {
            Cache::forget(static::cacheKey());
        } catch (\Throwable $e) {
            report($e);
        }
    }

    /**
     * @param  callable(): Collection<int, static>  $query
     * @param  \DateInterval|\DateTimeInterface|int|null  $ttl  Null caches forever.
     * @return Collection<int, static>
     */
    protected static function rememberQuery(callable $query, \DateInterval|\DateTimeInterface|int|null $ttl = null): Collection
    {
        $toRows = fn () => $query()->map(fn (self $model) => $model->getAttributes())->all();

        try {
            $rows = $ttl === null
                ? Cache::rememberForever(static::cacheKey(), $toRows)
                : Cache::remember(static::cacheKey(), $ttl, $toRows);
        } catch (\Throwable $e) {
            // Redis being slow/unreachable shouldn't take the page down —
            // fall straight through to the real query instead of caching.
            report($e);

            return $query();
        }

        return static::hydrate($rows);
    }
}
