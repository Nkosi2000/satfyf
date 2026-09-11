<?php

use App\Models\Article;

describe('index', function () {
    it('lists published articles', function () {
        $article = Article::factory()->create(['title' => 'Visible Article']);

        $this->get('/articles')
            ->assertOk()
            ->assertSee('Visible Article');
    });

    it('does not list draft articles', function () {
        Article::factory()->draft()->create(['title' => 'Draft Article']);

        $this->get('/articles')
            ->assertOk()
            ->assertDontSee('Draft Article');
    });
});

describe('show', function () {
    it('renders a published article', function () {
        $article = Article::factory()->create(['title' => 'A Published Article', 'body' => 'Some **markdown** body.']);

        $this->get(route('articles.show', $article))
            ->assertOk()
            ->assertSee('A Published Article')
            ->assertSee('markdown');
    });

    it('returns 404 for a draft article', function () {
        $article = Article::factory()->draft()->create();

        $this->get(route('articles.show', $article))->assertNotFound();
    });

    it('returns 404 for an article scheduled in the future', function () {
        $article = Article::factory()->create(['published_at' => now()->addWeek()]);

        $this->get(route('articles.show', $article))->assertNotFound();
    });
});
