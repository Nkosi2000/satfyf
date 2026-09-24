---
paths:
  - app/helpers.php
  - app/Console/Commands/*.php
---

# Storage URLs

## Every `storage_url()` cache entry must stay warm via the schedule, not first-request-pays-the-cost
`storage_url()` (app/helpers.php) wraps `Storage::disk('public')->temporaryUrl()` in a 5h30m `Cache::remember()` because signing a URL against Neon Storage (the S3-compatible provider backing the `public` disk) takes roughly 1s per call — not the near-instant local HMAC sign a stock S3 presign normally is. A content-heavy page (home, gallery, articles) calls it a dozen-plus times per render; the moment those cache entries expire together (e.g. right after a deploy, or simply because they were all written around the same time), the next real request pays every signing cost sequentially and can exceed PHP's 30s `max_execution_time` — a `FatalError`, not a catchable exception, so there's no graceful fallback once it happens. Root-caused 2026-09-22 after the home page started 500ing with `Maximum execution time of 30 seconds exceeded`.

Fixed by `App\Console\Commands\WarmStorageUrls` (`php artisan app:warm-storage-urls`), scheduled hourly in `bootstrap/app.php` — well inside the 5h30m TTL — so cache entries are always refreshed before they expire and a real request never computes them cold. It iterates every model with a stored file path (`GalleryImage`, `GoalImage`, `Partner`, `Testimonial`, `TeamMember`, `Article` cover+attachment, `ArticleImage`, `EventItem`, `Resource`), including unpublished rows (admin screens call `storage_url()` too).

If a new model or column starts storing a file path signed through `storage_url()`, add its path(s) to `WarmStorageUrls::handle()` — otherwise that path silently falls back to cold-signing on first render.

The scheduler only runs if something actually calls `php artisan schedule:run` every minute (or Laravel Cloud's scheduler is active) — confirm that's wired up in whatever environment this deploys to, or the warm command never fires and this regresses.

Testing this against the real `public` disk hits Neon Storage with live production credentials from `.env` (slow — ~1s/call — and a real S3 call), even under `Storage::disk('public')->buildTemporaryUrlsUsing(...)`: `FilesystemAdapter::temporaryUrl()` prefers `$adapter->getTemporaryUrl()` when the adapter defines it (true for the S3 adapter), so a registered callback is silently ignored unless the adapter itself is swapped out first. Use `Storage::fake('public')->buildTemporaryUrlsUsing(...)` instead — `fake()` replaces the adapter with a local one that has no `getTemporaryUrl()`, so the callback actually gets consulted.
