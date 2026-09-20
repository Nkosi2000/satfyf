<?php

use App\Models\Article;
use App\Models\EventItem;
use App\Models\FaqItem;
use App\Models\GalleryImage;
use App\Models\Partner;
use App\Models\Resource;
use App\Models\TeamMember;
use App\Models\Testimonial;

it('lists published articles and hides drafts', function () {
    Article::factory()->create(['title' => 'Published Piece']);
    Article::factory()->draft()->create(['title' => 'Draft Piece']);

    $this->getJson('/api/v1/articles')
        ->assertOk()
        ->assertJsonFragment(['title' => 'Published Piece'])
        ->assertJsonMissing(['title' => 'Draft Piece']);
});

it('shows a single published article by slug', function () {
    $article = Article::factory()->create(['title' => 'Deep Dive']);

    $this->getJson("/api/v1/articles/{$article->slug}")
        ->assertOk()
        ->assertJsonPath('data.title', 'Deep Dive')
        ->assertJsonPath('data.slug', $article->slug)
        ->assertJsonStructure(['data' => ['id', 'slug', 'title', 'excerpt', 'body_html', 'author_name', 'cover_image_url', 'attachment', 'published_at']]);
});

it('404s for a draft article requested by slug', function () {
    $article = Article::factory()->draft()->create();

    $this->getJson("/api/v1/articles/{$article->slug}")->assertNotFound();
});

it('lists published events and can filter to upcoming only', function () {
    EventItem::factory()->create(['title' => 'Past Event', 'starts_at' => now()->subMonth(), 'ends_at' => now()->subMonth()->addHours(2)]);
    EventItem::factory()->create(['title' => 'Future Event', 'starts_at' => now()->addMonth(), 'ends_at' => now()->addMonth()->addHours(2)]);

    $this->getJson('/api/v1/events')
        ->assertOk()
        ->assertJsonFragment(['title' => 'Past Event'])
        ->assertJsonFragment(['title' => 'Future Event']);

    $this->getJson('/api/v1/events?upcoming=1')
        ->assertOk()
        ->assertJsonFragment(['title' => 'Future Event'])
        ->assertJsonMissing(['title' => 'Past Event']);
});

it('shows a single published event by slug', function () {
    $event = EventItem::factory()->create(['title' => 'Media Briefing']);

    $this->getJson("/api/v1/events/{$event->slug}")
        ->assertOk()
        ->assertJsonPath('data.title', 'Media Briefing');
});

it('lists gallery images', function () {
    GalleryImage::factory()->create(['caption' => 'Chapter Launch']);

    $this->getJson('/api/v1/gallery-images')
        ->assertOk()
        ->assertJsonFragment(['caption' => 'Chapter Launch']);
});

it('lists published resources with a working download url', function () {
    $resource = Resource::factory()->create(['title' => 'Fact Sheet', 'published' => true]);
    Resource::factory()->create(['title' => 'Hidden Sheet', 'published' => false]);

    $this->getJson('/api/v1/resources')
        ->assertOk()
        ->assertJsonFragment(['title' => 'Fact Sheet', 'download_url' => route('resources.download', $resource)])
        ->assertJsonMissing(['title' => 'Hidden Sheet']);
});

it('lists published team members', function () {
    TeamMember::factory()->create(['name' => 'Zanele Test', 'published' => true]);
    TeamMember::factory()->create(['name' => 'Hidden Member', 'published' => false]);

    $this->getJson('/api/v1/team-members')
        ->assertOk()
        ->assertJsonFragment(['name' => 'Zanele Test'])
        ->assertJsonMissing(['name' => 'Hidden Member']);
});

it('lists published partners', function () {
    Partner::factory()->create(['name' => 'Test Partner Org', 'published' => true]);
    Partner::factory()->create(['name' => 'Hidden Org', 'published' => false]);

    $this->getJson('/api/v1/partners')
        ->assertOk()
        ->assertJsonFragment(['name' => 'Test Partner Org'])
        ->assertJsonMissing(['name' => 'Hidden Org']);
});

it('lists published testimonials', function () {
    Testimonial::factory()->create(['name' => 'Happy Voice', 'published' => true]);
    Testimonial::factory()->create(['name' => 'Hidden Voice', 'published' => false]);

    $this->getJson('/api/v1/testimonials')
        ->assertOk()
        ->assertJsonFragment(['name' => 'Happy Voice'])
        ->assertJsonMissing(['name' => 'Hidden Voice']);
});

it('lists published faqs', function () {
    FaqItem::factory()->create(['question' => 'What does SATFYF do?', 'published' => true]);
    FaqItem::factory()->create(['question' => 'Hidden question?', 'published' => false]);

    $this->getJson('/api/v1/faqs')
        ->assertOk()
        ->assertJsonFragment(['question' => 'What does SATFYF do?'])
        ->assertJsonMissing(['question' => 'Hidden question?']);
});
