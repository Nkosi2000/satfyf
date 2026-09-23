<?php

use App\Models\Article;
use Illuminate\Support\Facades\Storage;

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

    it('renders the pagination controls when there is more than one page', function () {
        Article::factory()->count(15)->create();

        $this->get('/articles')
            ->assertOk()
            ->assertSee('Page navigation');
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

    it('renders a short article body in newspaper-style columns', function () {
        $article = Article::factory()->create(['body' => str_repeat('word ', 50)]);

        $this->get(route('articles.show', $article))
            ->assertOk()
            ->assertSee('article-columns', false);
    });

    it('does not column-format a long article body', function () {
        $article = Article::factory()->create(['body' => str_repeat('word ', 300)]);

        $this->get(route('articles.show', $article))
            ->assertOk()
            ->assertDontSee('article-columns', false);
    });

    it('strips raw HTML out of the rendered markdown body', function () {
        $article = Article::factory()->create(['body' => "<script>alert('xss')</script>\n\nSome **safe** text."]);

        $this->get(route('articles.show', $article))
            ->assertOk()
            // The page's own bundled JS still legitimately contains a
            // <script> tag — check for the specific injected payload, not
            // the bare tag.
            ->assertDontSee("<script>alert('xss')", false)
            ->assertSee('Some <strong>safe</strong> text.', false);
    });

    it('returns 404 for an article scheduled in the future', function () {
        $article = Article::factory()->create(['published_at' => now()->addWeek()]);

        $this->get(route('articles.show', $article))->assertNotFound();
    });

    it('shows a download link when the article has an attachment', function () {
        $article = Article::factory()->create([
            'attachment_path' => 'articles/attachments/report.pdf',
            'attachment_name' => 'report.pdf',
        ]);

        $this->get(route('articles.show', $article))
            ->assertOk()
            ->assertSee('Download attachment')
            ->assertSee('report.pdf');
    });

    it('does not show a download link when the article has no attachment', function () {
        $article = Article::factory()->create();

        $this->get(route('articles.show', $article))
            ->assertOk()
            ->assertDontSee('Download attachment');
    });

    it('shows body images in order', function () {
        Storage::fake('public');
        // storage_url() calls temporaryUrl(), which the local fake disk
        // doesn't support without an explicit callback — fall back to a
        // plain url() so it still returns something with the path in it.
        Storage::disk('public')->buildTemporaryUrlsUsing(fn ($path, $expiration) => Storage::disk('public')->url($path));
        Storage::disk('public')->put('articles/images/second.jpg', 'contents');
        Storage::disk('public')->put('articles/images/first.jpg', 'contents');
        $article = Article::factory()->create();
        $article->images()->create(['image_path' => 'articles/images/second.jpg', 'order' => 2]);
        $article->images()->create(['image_path' => 'articles/images/first.jpg', 'order' => 1]);

        $response = $this->get(route('articles.show', $article));

        $response->assertOk();
        $firstPosition = strpos($response->getContent(), 'articles/images/first.jpg');
        $secondPosition = strpos($response->getContent(), 'articles/images/second.jpg');
        expect($firstPosition)->toBeLessThan($secondPosition);
    });

    it('does not render an image gallery when the article has no body images', function () {
        $article = Article::factory()->create();

        $this->get(route('articles.show', $article))
            ->assertOk()
            ->assertDontSee('articles/images/', false);
    });
});

describe('attachment', function () {
    it('redirects to the stored file for a published article', function () {
        Storage::fake('public');
        Storage::disk('public')->buildTemporaryUrlsUsing(fn ($path, $expiration) => Storage::disk('public')->url($path));
        Storage::disk('public')->put('articles/attachments/report.pdf', 'contents');
        $article = Article::factory()->create([
            'attachment_path' => 'articles/attachments/report.pdf',
            'attachment_name' => 'report.pdf',
        ]);

        $this->get(route('articles.attachment', $article))
            ->assertRedirect(Storage::disk('public')->url('articles/attachments/report.pdf'));
    });

    it('returns 404 when the article has no attachment', function () {
        $article = Article::factory()->create();

        $this->get(route('articles.attachment', $article))->assertNotFound();
    });

    it('returns 404 for a draft article', function () {
        $article = Article::factory()->draft()->create([
            'attachment_path' => 'articles/attachments/report.pdf',
            'attachment_name' => 'report.pdf',
        ]);

        $this->get(route('articles.attachment', $article))->assertNotFound();
    });
});
