<?php

use App\Models\Article;
use App\Models\ArticleImage;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    $this->admin = User::factory()->admin()->create();
});

it('redirects guests away from the article list', function () {
    $this->get(route('admin.articles.index'))->assertRedirect(route('admin.login'));
});

describe('index', function () {
    it('lists every article regardless of publish state', function () {
        Article::factory()->create(['title' => 'Published One']);
        Article::factory()->draft()->create(['title' => 'Draft One']);

        $this->actingAs($this->admin)
            ->get(route('admin.articles.index'))
            ->assertOk()
            ->assertSee('Published One')
            ->assertSee('Draft One');
    });
});

describe('store', function () {
    it('creates an article with an uploaded cover image', function () {
        Storage::fake('public');

        $response = $this->actingAs($this->admin)->post(route('admin.articles.store'), [
            'title' => ['en' => 'New Article'],
            'slug' => 'new-article',
            'excerpt' => ['en' => 'A short summary.'],
            'body' => ['en' => 'Full **markdown** body.'],
            'author_name' => 'Admin Writer',
            'cover_image' => UploadedFile::fake()->image('cover.jpg'),
            'published_at' => now()->format('Y-m-d\TH:i'),
        ]);

        $article = Article::query()->where('slug', 'new-article')->firstOrFail();
        $response->assertRedirect(route('admin.articles.edit', $article));

        expect($article->title)->toBe('New Article');
        Storage::disk('public')->assertExists($article->cover_image_path);
    });

    it('rejects a submission with an empty payload', function () {
        $response = $this->actingAs($this->admin)->post(route('admin.articles.store'), []);

        $response->assertSessionHasErrors(['title.en', 'slug', 'excerpt.en', 'body.en']);
        expect(Article::query()->count())->toBe(0);
    });

    it('rejects a duplicate slug', function () {
        Article::factory()->create(['slug' => 'taken-slug']);

        $response = $this->actingAs($this->admin)->post(route('admin.articles.store'), [
            'title' => ['en' => 'Another Article'],
            'slug' => 'taken-slug',
            'excerpt' => ['en' => 'Summary.'],
            'body' => ['en' => 'Body.'],
        ]);

        $response->assertSessionHasErrors('slug');
    });

    it('creates an article with an uploaded attachment', function () {
        Storage::fake('public');

        $response = $this->actingAs($this->admin)->post(route('admin.articles.store'), [
            'title' => ['en' => 'Article With Attachment'],
            'slug' => 'article-with-attachment',
            'excerpt' => ['en' => 'A short summary.'],
            'body' => ['en' => 'Full body.'],
            'attachment' => UploadedFile::fake()->create('report.pdf', 100, 'application/pdf'),
        ]);

        $article = Article::query()->where('slug', 'article-with-attachment')->firstOrFail();
        $response->assertRedirect(route('admin.articles.edit', $article));

        expect($article->attachment_name)->toBe('report.pdf');
        Storage::disk('public')->assertExists($article->attachment_path);
    });

    it('stores every submitted locale of a translatable field, each resolving under its own locale', function () {
        $response = $this->actingAs($this->admin)->post(route('admin.articles.store'), [
            'title' => ['en' => 'English Title', 'zu' => 'Isihloko SesiZulu', 'st' => '', 'af' => null],
            'slug' => 'multi-locale-article',
            'excerpt' => ['en' => 'English excerpt.'],
            'body' => ['en' => 'English body.'],
        ]);

        $article = Article::query()->where('slug', 'multi-locale-article')->firstOrFail();
        $response->assertRedirect(route('admin.articles.edit', $article));

        expect($article->translations('title'))->toBe(['en' => 'English Title', 'zu' => 'Isihloko SesiZulu']);

        app()->setLocale('zu');
        expect($article->refresh()->title)->toBe('Isihloko SesiZulu');

        app()->setLocale('af');
        expect($article->refresh()->title)->toBe('English Title');

        app()->setLocale('en');
    });
});

describe('update', function () {
    it('updates an article and replaces its cover image', function () {
        Storage::fake('public');
        $article = Article::factory()->create(['cover_image_path' => 'articles/old.jpg']);
        Storage::disk('public')->put('articles/old.jpg', 'old contents');

        $response = $this->actingAs($this->admin)->put(route('admin.articles.update', $article), [
            'title' => ['en' => 'Updated Title'],
            'slug' => $article->slug,
            'excerpt' => ['en' => $article->excerpt],
            'body' => ['en' => $article->body],
            'cover_image' => UploadedFile::fake()->image('new-cover.jpg'),
        ]);

        $response->assertRedirect(route('admin.articles.index'));

        $article->refresh();
        expect($article->title)->toBe('Updated Title');
        Storage::disk('public')->assertMissing('articles/old.jpg');
        Storage::disk('public')->assertExists($article->cover_image_path);
    });

    it('replaces an existing attachment and removes the old file', function () {
        Storage::fake('public');
        $article = Article::factory()->create([
            'attachment_path' => 'articles/attachments/old.pdf',
            'attachment_name' => 'old.pdf',
        ]);
        Storage::disk('public')->put('articles/attachments/old.pdf', 'old contents');

        $response = $this->actingAs($this->admin)->put(route('admin.articles.update', $article), [
            'title' => ['en' => $article->title],
            'slug' => $article->slug,
            'excerpt' => ['en' => $article->excerpt],
            'body' => ['en' => $article->body],
            'attachment' => UploadedFile::fake()->create('new-report.pdf', 100, 'application/pdf'),
        ]);

        $response->assertRedirect(route('admin.articles.index'));

        $article->refresh();
        expect($article->attachment_name)->toBe('new-report.pdf');
        Storage::disk('public')->assertMissing('articles/attachments/old.pdf');
        Storage::disk('public')->assertExists($article->attachment_path);
    });

    it('allows keeping the existing slug unchanged', function () {
        $article = Article::factory()->create(['slug' => 'stable-slug']);

        $response = $this->actingAs($this->admin)->put(route('admin.articles.update', $article), [
            'title' => ['en' => 'Renamed'],
            'slug' => 'stable-slug',
            'excerpt' => ['en' => $article->excerpt],
            'body' => ['en' => $article->body],
        ]);

        $response->assertRedirect(route('admin.articles.index'));
        expect($article->refresh()->slug)->toBe('stable-slug');
    });
});

it('deletes an article, its cover image, its attachment, and its body images', function () {
    Storage::fake('public');
    $article = Article::factory()->create([
        'cover_image_path' => 'articles/to-delete.jpg',
        'attachment_path' => 'articles/attachments/to-delete.pdf',
    ]);
    Storage::disk('public')->put('articles/to-delete.jpg', 'contents');
    Storage::disk('public')->put('articles/attachments/to-delete.pdf', 'contents');
    Storage::disk('public')->put('articles/images/gallery.jpg', 'contents');
    $article->images()->create(['image_path' => 'articles/images/gallery.jpg', 'order' => 1]);

    $response = $this->actingAs($this->admin)->delete(route('admin.articles.destroy', $article));

    $response->assertRedirect(route('admin.articles.index'));
    expect(Article::query()->find($article->id))->toBeNull();
    expect(ArticleImage::query()->count())->toBe(0);
    Storage::disk('public')->assertMissing('articles/to-delete.jpg');
    Storage::disk('public')->assertMissing('articles/attachments/to-delete.pdf');
    Storage::disk('public')->assertMissing('articles/images/gallery.jpg');
});

describe('images', function () {
    it('redirects guests away', function () {
        $article = Article::factory()->create();

        $this->post(route('admin.articles.images.store', $article), [
            'images' => [UploadedFile::fake()->image('a.jpg')],
        ])->assertRedirect(route('admin.login'));
    });

    it('uploads multiple images and assigns increasing order', function () {
        Storage::fake('public');
        $article = Article::factory()->create();

        $response = $this->actingAs($this->admin)->post(route('admin.articles.images.store', $article), [
            'images' => [
                UploadedFile::fake()->image('a.jpg'),
                UploadedFile::fake()->image('b.jpg'),
            ],
        ]);

        $response->assertRedirect(route('admin.articles.edit', $article));

        $images = $article->images()->get();
        expect($images)->toHaveCount(2);
        expect($images->pluck('order')->all())->toBe([1, 2]);
        foreach ($images as $image) {
            Storage::disk('public')->assertExists($image->image_path);
        }
    });

    it('appends to existing images rather than replacing them', function () {
        Storage::fake('public');
        $article = Article::factory()->create();
        $article->images()->create(['image_path' => 'articles/images/existing.jpg', 'order' => 1]);

        $this->actingAs($this->admin)->post(route('admin.articles.images.store', $article), [
            'images' => [UploadedFile::fake()->image('new.jpg')],
        ]);

        expect($article->images()->count())->toBe(2);
    });

    it('rejects a non-image file', function () {
        $article = Article::factory()->create();

        $response = $this->actingAs($this->admin)->post(route('admin.articles.images.store', $article), [
            'images' => [UploadedFile::fake()->create('not-an-image.pdf', 100, 'application/pdf')],
        ]);

        $response->assertSessionHasErrors('images.0');
    });

    it('deletes an image and its file', function () {
        Storage::fake('public');
        Storage::disk('public')->put('articles/images/to-delete.jpg', 'contents');
        $article = Article::factory()->create();
        $image = $article->images()->create(['image_path' => 'articles/images/to-delete.jpg', 'order' => 1]);

        $response = $this->actingAs($this->admin)->delete(route('admin.articles.images.destroy', [$article, $image]));

        $response->assertRedirect(route('admin.articles.edit', $article));
        expect(ArticleImage::query()->find($image->id))->toBeNull();
        Storage::disk('public')->assertMissing('articles/images/to-delete.jpg');
    });

    it('refuses to delete an image belonging to a different article', function () {
        $article = Article::factory()->create();
        $otherArticle = Article::factory()->create();
        $image = $otherArticle->images()->create(['image_path' => 'articles/images/other.jpg', 'order' => 1]);

        $this->actingAs($this->admin)
            ->delete(route('admin.articles.images.destroy', [$article, $image]))
            ->assertNotFound();

        expect(ArticleImage::query()->find($image->id))->not->toBeNull();
    });
});
