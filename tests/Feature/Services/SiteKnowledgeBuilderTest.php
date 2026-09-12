<?php

use App\Models\Article;
use App\Models\EventItem;
use App\Models\FaqItem;
use App\Models\Program;
use App\Services\Chat\SiteKnowledgeBuilder;

it('includes published content', function () {
    Program::factory()->create(['title' => 'Youth Ambassadors']);
    FaqItem::factory()->create(['question' => 'Is SATFYF free to join?']);
    Article::factory()->create(['title' => 'A Recent Story']);

    $knowledge = app(SiteKnowledgeBuilder::class)->build();

    expect($knowledge)
        ->toContain('Youth Ambassadors')
        ->toContain('Is SATFYF free to join?')
        ->toContain('A Recent Story');
});

it('excludes unpublished content', function () {
    Program::factory()->create(['title' => 'Hidden Program', 'published' => false]);
    FaqItem::factory()->create(['question' => 'Hidden question?', 'published' => false]);
    Article::factory()->draft()->create(['title' => 'Hidden Draft Article']);
    EventItem::factory()->create(['title' => 'Hidden Event', 'published' => false]);

    $knowledge = app(SiteKnowledgeBuilder::class)->build();

    expect($knowledge)
        ->not->toContain('Hidden Program')
        ->not->toContain('Hidden question?')
        ->not->toContain('Hidden Draft Article')
        ->not->toContain('Hidden Event');
});

it('excludes past events', function () {
    EventItem::factory()->create(['title' => 'A Past Event', 'starts_at' => now()->subMonth()]);

    $knowledge = app(SiteKnowledgeBuilder::class)->build();

    expect($knowledge)->not->toContain('A Past Event');
});

it('resolves translatable fields under the active locale', function () {
    Program::factory()->create(['title' => ['en' => 'English Title', 'zu' => 'Isihloko SesiZulu']]);

    app()->setLocale('zu');
    $knowledge = app(SiteKnowledgeBuilder::class)->build();
    app()->setLocale('en');

    expect($knowledge)
        ->toContain('Isihloko SesiZulu')
        ->not->toContain('English Title');
});
