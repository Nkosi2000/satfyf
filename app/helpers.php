<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

if (! function_exists('storage_url')) {
    /**
     * A working URL for a file on the given disk.
     *
     * The "public" disk is an S3-compatible bucket (Neon Storage) with no
     * public-read policy — the provider doesn't support per-object ACLs
     * either, so a plain Storage::url() always 403s. Every reference to a
     * stored file goes through a signed, time-limited temporaryUrl()
     * instead. Returns null when $path is null so call sites don't need
     * their own conditional, and passes external URLs (e.g. a gallery
     * image seeded with a full http(s) link) straight through.
     *
     * temporaryUrl() itself is genuinely slow on this provider (~1-1.5s
     * per call, not a cheap local HMAC sign) — a page rendering ~18 images
     * (home's hero + partner logos + gallery) paid that cost sequentially
     * on every single request, which was enough on its own to exceed
     * PHP's 30s execution limit and 500 the page (root-caused 2026-09-22;
     * Redis/Postgres were red herrings — both were fast in isolation).
     * Caching the generated URL for less than its own validity window
     * means only the first request after a deploy/cache-clear pays the
     * real cost; every request after that is a fast local cache read.
     */
    function storage_url(?string $path, string $disk = 'public'): ?string
    {
        if ($path === null || $path === '') {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        return Cache::remember(
            "storage_url:{$disk}:{$path}",
            now()->addMinutes(330), // 5h30m — safely under the URL's own 6h validity
            fn () => Storage::disk($disk)->temporaryUrl($path, now()->addHours(6)),
        );
    }
}
