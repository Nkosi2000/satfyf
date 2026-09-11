---
paths:
  - 'app/Models/*.php'
---

# Models

## Never cache Eloquent model instances via the database cache driver
CACHE_STORE=database, so Cache::remember() values are PHP-serialized into the `cache` table. Caching an Eloquent model or Collection-of-models this way silently breaks on unserialize (`__PHP_Incomplete_Class` TypeError) — see SiteSetting::allRows(), which caches ->toArray() plain arrays instead and rebuilds a plain Support\Collection from them. Follow the same pattern for any other model-level cache.
