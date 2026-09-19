<?php

use App\Models\Article;
use App\Models\EventItem;
use App\Models\FaqItem;

it('renders an empty search page with no query', function () {
    $this->get('/search')
        ->assertOk()
        ->assertSee(__('Search the site.'));
});

it('finds a published article by title', function () {
    Article::factory()->create(['title' => ['en' => 'Vaping Isn\'t Safer']]);

    $this->get('/search?q=vaping')
        ->assertOk()
        ->assertSee('Vaping Isn\'t Safer');
});

it('does not find an unpublished article', function () {
    Article::factory()->create(['title' => ['en' => 'Draft About Vaping'], 'published_at' => null]);

    $this->get('/search?q=vaping')
        ->assertOk()
        ->assertDontSee('Draft About Vaping');
});

it('finds a published event by title', function () {
    EventItem::factory()->create(['title' => ['en' => 'Centurion Think Session'], 'published' => true]);

    $this->get('/search?q=centurion')
        ->assertOk()
        ->assertSee('Centurion Think Session');
});

it('finds an faq by its answer text, not just the question', function () {
    FaqItem::factory()->create([
        'question' => ['en' => 'How is SATFYF funded?'],
        'answer' => ['en' => 'Through partnerships, grants and donor support.'],
        'published' => true,
    ]);

    $this->get('/search?q=donor')
        ->assertOk()
        ->assertSee('How is SATFYF funded?');
});

it('shows an empty state when nothing matches', function () {
    Article::factory()->create(['title' => ['en' => 'Something Else']]);

    $this->get('/search?q=xyznotfound')
        ->assertOk()
        ->assertSee(__('No results for ":query" — try a different word.', ['query' => 'xyznotfound']));
});
