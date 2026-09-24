<?php

namespace App\Console\Commands;

use App\Models\Article;
use App\Models\ArticleImage;
use App\Models\EventItem;
use App\Models\GalleryImage;
use App\Models\GoalImage;
use App\Models\Partner;
use App\Models\Resource;
use App\Models\TeamMember;
use App\Models\Testimonial;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

/**
 * storage_url() (app/helpers.php) caches each signed URL for 5h30m because
 * Neon Storage's temporaryUrl() takes roughly 1s per call — a public page
 * that renders many images (home, gallery, articles) pays that cost
 * sequentially the moment any of those cache entries expire, which is
 * enough on its own to exceed PHP's 30s execution limit and 500 the page
 * (root-caused 2026-09-22). Running this on a schedule well inside that
 * TTL keeps every entry warm so a real request never pays the cold cost.
 *
 * That protection only holds if the schedule itself is actually running
 * (cron calling `schedule:run` every minute, or Laravel Cloud's scheduler) —
 * a silently stopped scheduler brings back the exact cold-cache risk this
 * command exists to prevent, with no error to notice until a real visitor
 * hits it. lastSucceededAt()/isStale() let the admin dashboard surface that
 * before it becomes an outage again.
 */
#[Signature('app:warm-storage-urls')]
#[Description('Refresh cached storage_url() signed URLs before they expire, so public pages never pay the slow signing cost on a live request')]
class WarmStorageUrls extends Command
{
    private const HEARTBEAT_KEY = 'scheduler:warm-storage-urls:last-success';

    /**
     * Command runs hourly; anything more than twice that old means at least
     * one run was missed outright, not just running a little late.
     */
    private const STALE_AFTER_HOURS = 2;

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $paths = [
            ...GalleryImage::pluck('image_path'),
            ...GoalImage::pluck('image_path'),
            ...Partner::whereNotNull('logo_path')->pluck('logo_path'),
            ...Testimonial::whereNotNull('photo_path')->pluck('photo_path'),
            ...TeamMember::whereNotNull('photo_path')->pluck('photo_path'),
            ...Article::whereNotNull('cover_image_path')->pluck('cover_image_path'),
            ...Article::whereNotNull('attachment_path')->pluck('attachment_path'),
            ...ArticleImage::pluck('image_path'),
            ...EventItem::whereNotNull('cover_image_path')->pluck('cover_image_path'),
            ...Resource::pluck('file_path'),
        ];

        $paths = array_unique(array_filter($paths));

        $this->withProgressBar($paths, fn (string $path) => storage_url($path));

        // A plain ISO-8601 string, not a Carbon instance — this cache store
        // has serializable_classes disabled (config/cache.php), so a stored
        // object would come back as __PHP_Incomplete_Class instead of a
        // usable Carbon. Same rule the Cacheable trait follows.
        Cache::forever(self::HEARTBEAT_KEY, now()->toIso8601String());

        $this->newLine(2);
        $this->info(count($paths).' storage URLs warmed.');
    }

    public static function lastSucceededAt(): ?Carbon
    {
        $value = Cache::get(self::HEARTBEAT_KEY);

        return $value ? Carbon::parse($value) : null;
    }

    /**
     * True if the command has never completed, or hasn't completed recently
     * enough to trust that storage_url()'s cache is still warm.
     */
    public static function isStale(): bool
    {
        $lastSucceededAt = self::lastSucceededAt();

        return $lastSucceededAt === null || $lastSucceededAt->lt(now()->subHours(self::STALE_AFTER_HOURS));
    }
}
