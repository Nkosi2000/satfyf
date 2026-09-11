<?php

use App\Models\Article;
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
            'title' => 'New Article',
            'slug' => 'new-article',
            'excerpt' => 'A short summary.',
            'body' => 'Full **markdown** body.',
            'author_name' => 'Admin Writer',
            'cover_image' => UploadedFile::fake()->image('cover.jpg'),
            'published_at' => now()->format('Y-m-d\TH:i'),
        ]);

        $response->assertRedirect(route('admin.articles.index'));

        $article = Article::query()->where('slug', 'new-article')->firstOrFail();
        expect($article->title)->toBe('New Article');
        Storage::disk('public')->assertExists($article->cover_image_path);
    });

    it('rejects a submission with an empty payload', function () {
        $response = $this->actingAs($this->admin)->post(route('admin.articles.store'), []);

        $response->assertSessionHasErrors(['title', 'slug', 'excerpt', 'body']);
        expect(Article::query()->count())->toBe(0);
    });

    it('rejects a duplicate slug', function () {
        Article::factory()->create(['slug' => 'taken-slug']);

        $response = $this->actingAs($this->admin)->post(route('admin.articles.store'), [
            'title' => 'Another Article',
            'slug' => 'taken-slug',
            'excerpt' => 'Summary.',
            'body' => 'Body.',
        ]);

        $response->assertSessionHasErrors('slug');
    });
});

describe('update', function () {
    it('updates an article and replaces its cover image', function () {
        Storage::fake('public');
        $article = Article::factory()->create(['cover_image_path' => 'articles/old.jpg']);
        Storage::disk('public')->put('articles/old.jpg', 'old contents');

        $response = $this->actingAs($this->admin)->put(route('admin.articles.update', $article), [
            'title' => 'Updated Title',
            'slug' => $article->slug,
            'excerpt' => $article->excerpt,
            'body' => $article->body,
            'cover_image' => UploadedFile::fake()->image('new-cover.jpg'),
        ]);

        $response->assertRedirect(route('admin.articles.index'));

        $article->refresh();
        expect($article->title)->toBe('Updated Title');
        Storage::disk('public')->assertMissing('articles/old.jpg');
        Storage::disk('public')->assertExists($article->cover_image_path);
    });

    it('allows keeping the existing slug unchanged', function () {
        $article = Article::factory()->create(['slug' => 'stable-slug']);

        $response = $this->actingAs($this->admin)->put(route('admin.articles.update', $article), [
            'title' => 'Renamed',
            'slug' => 'stable-slug',
            'excerpt' => $article->excerpt,
            'body' => $article->body,
        ]);

        $response->assertRedirect(route('admin.articles.index'));
        expect($article->refresh()->slug)->toBe('stable-slug');
    });
});

it('deletes an article and its cover image', function () {
    Storage::fake('public');
    $article = Article::factory()->create(['cover_image_path' => 'articles/to-delete.jpg']);
    Storage::disk('public')->put('articles/to-delete.jpg', 'contents');

    $response = $this->actingAs($this->admin)->delete(route('admin.articles.destroy', $article));

    $response->assertRedirect(route('admin.articles.index'));
    expect(Article::query()->find($article->id))->toBeNull();
    Storage::disk('public')->assertMissing('articles/to-delete.jpg');
});
