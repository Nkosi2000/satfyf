<?php

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
     */
    function storage_url(?string $path, string $disk = 'public'): ?string
    {
        if ($path === null || $path === '') {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        return Storage::disk($disk)->temporaryUrl($path, now()->addHours(6));
    }
}
