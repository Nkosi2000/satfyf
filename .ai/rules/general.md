---
paths:
  - .env
---

# General

## Local dev runs against Neon Postgres via DB_URL, not the local host/user in .env
config/database.php's pgsql connection reads `env('DB_URL')` first, which overrides DB_HOST/DB_USERNAME/DB_PASSWORD when set. `.env` sets DB_URL to the Neon pooled connection string — the DB_HOST=127.0.0.1/DB_USERNAME=root values below it are unused leftovers from the Laravel skeleton and will fail if DB_URL is ever removed.

For schema migrations, temporarily override DB_URL to the *unpooled* Neon host (no `-pooler` suffix, same credentials — see DATABASE_URL_UNPOOLED in .env) since Neon's guidance is direct connections for migrations, pooled for app runtime: `DB_URL="<unpooled url>" php artisan migrate`.

phpunit.xml already clears DB_URL to "" and forces sqlite `:memory:` for the test suite — tests never touch the real Neon database.

## CACHE_STORE must not be 'database' — Cache::increment()/decrement() breaks on Neon's pooled connection
Laravel's DatabaseStore::increment()/decrement() (used internally by RateLimiter::hit(), so also by any `throttle:*` middleware) wraps a SELECT+UPDATE in an explicit DB::transaction(). Neon's pooled (PgBouncer transaction-mode) connection cannot reliably sustain that multi-statement transaction — it fails with `SQLSTATE[25P02]: current transaction is aborted` on the UPDATE, reproducible via plain `Cache::increment()` in tinker. This is the same underlying PgBouncer limitation documented for migrations (see the `$withinTransaction = false` pattern), but it also breaks a stock, unmodified Laravel feature (rate limiting) at runtime, not just DDL.

Fixed by setting `CACHE_STORE=file` (in `.env` and `.env.example`) instead of `database`. `Cache::rememberForever()`/`put()`/`get()` (e.g. SiteSetting::allRows()) are unaffected either way — only increment/decrement is broken — but there's no good reason to keep fighting Neon for a single-server app, so the whole default store was moved off Postgres. If a future need requires the database store specifically, avoid `Cache::increment()`/`decrement()` against it (use get+put instead) rather than reintroducing this bug.
