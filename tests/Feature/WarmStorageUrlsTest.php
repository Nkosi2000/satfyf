<?php

use App\Console\Commands\WarmStorageUrls;
use App\Models\Article;
use App\Models\ArticleImage;
use App\Models\EventItem;
use App\Models\GalleryImage;
use App\Models\Partner;
use App\Models\Resource;
use App\Models\TeamMember;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

it('caches a signed url for every stored file path across every model', function () {
    Storage::fake('public')->buildTemporaryUrlsUsing(
        fn (string $path, DateTimeInterface $expiration) => "https://fake.test/{$path}"
    );

    $gallery = GalleryImage::factory()->create(['image_path' => 'gallery/one.jpg']);
    $partner = Partner::factory()->create(['logo_path' => 'partners/one.png']);
    $testimonial = Testimonial::factory()->create(['photo_path' => 'testimonials/one.jpg']);
    $teamMember = TeamMember::factory()->create(['photo_path' => 'team/one.jpg']);
    $article = Article::factory()->create([
        'cover_image_path' => 'articles/cover.jpg',
        'attachment_path' => 'articles/attachment.pdf',
    ]);
    $articleImage = ArticleImage::factory()->create(['article_id' => $article->id, 'image_path' => 'articles/inline.jpg']);
    $event = EventItem::factory()->create(['cover_image_path' => 'events/cover.jpg']);
    $resource = Resource::factory()->create(['file_path' => 'resources/one.pdf']);

    $this->artisan('app:warm-storage-urls')->assertSuccessful();

    expect(Cache::get('storage_url:public:'.$gallery->image_path))->toBe('https://fake.test/'.$gallery->image_path)
        ->and(Cache::get('storage_url:public:'.$partner->logo_path))->toBe('https://fake.test/'.$partner->logo_path)
        ->and(Cache::get('storage_url:public:'.$testimonial->photo_path))->toBe('https://fake.test/'.$testimonial->photo_path)
        ->and(Cache::get('storage_url:public:'.$teamMember->photo_path))->toBe('https://fake.test/'.$teamMember->photo_path)
        ->and(Cache::get('storage_url:public:'.$article->cover_image_path))->toBe('https://fake.test/'.$article->cover_image_path)
        ->and(Cache::get('storage_url:public:'.$article->attachment_path))->toBe('https://fake.test/'.$article->attachment_path)
        ->and(Cache::get('storage_url:public:'.$articleImage->image_path))->toBe('https://fake.test/'.$articleImage->image_path)
        ->and(Cache::get('storage_url:public:'.$event->cover_image_path))->toBe('https://fake.test/'.$event->cover_image_path)
        ->and(Cache::get('storage_url:public:'.$resource->file_path))->toBe('https://fake.test/'.$resource->file_path);
});

it('skips null file paths without error', function () {
    Storage::fake('public')->buildTemporaryUrlsUsing(
        fn (string $path, DateTimeInterface $expiration) => "https://fake.test/{$path}"
    );

    Partner::factory()->create(['logo_path' => null]);
    Testimonial::factory()->create(['photo_path' => null]);

    $this->artisan('app:warm-storage-urls')->assertSuccessful();
});

it('records a heartbeat on success that reports as fresh', function () {
    Storage::fake('public')->buildTemporaryUrlsUsing(
        fn (string $path, DateTimeInterface $expiration) => "https://fake.test/{$path}"
    );

    expect(WarmStorageUrls::isStale())->toBeTrue()
        ->and(WarmStorageUrls::lastSucceededAt())->toBeNull();

    $this->artisan('app:warm-storage-urls')->assertSuccessful();

    expect(WarmStorageUrls::isStale())->toBeFalse()
        ->and(WarmStorageUrls::lastSucceededAt())->not->toBeNull()
        ->and(WarmStorageUrls::lastSucceededAt()->diffInMinutes(now()))->toBeLessThan(1);
});

it('reports stale once the heartbeat is older than the threshold', function () {
    $this->travelTo(now()->subHours(3));
    Cache::forever('scheduler:warm-storage-urls:last-success', now()->toIso8601String());
    $this->travelBack();

    expect(WarmStorageUrls::isStale())->toBeTrue();
});
