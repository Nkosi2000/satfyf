<?php

use App\Models\Article;
use App\Models\SiteSetting;
use App\Models\User;

it('renders the home page in English by default', function () {
    SiteSetting::query()->updateOrCreate(
        ['key' => 'closing_cta_heading'],
        ['group' => 'closing_cta', 'value' => json_encode(['en' => 'Speak up. Stand out.'])],
    );

    $this->get('/')->assertOk()->assertSeeText('Speak up. Stand out.');
});

it('switches the rendered locale and persists it via cookie', function () {
    SiteSetting::query()->updateOrCreate(
        ['key' => 'closing_cta_heading'],
        ['group' => 'closing_cta', 'value' => json_encode(['en' => 'Speak up. Stand out.', 'zu' => 'Khuluma. Vela.'])],
    );

    $response = $this->get('/language/zu');

    $response->assertRedirect('/');
    $response->assertCookie('locale', 'zu');

    $this->get('/', ['Cookie' => 'locale=zu'])
        ->assertOk()
        ->assertSeeText('Khuluma. Vela.')
        ->assertSee('lang="zu"', false);
});

it('redirects back to the page the switcher was used from', function () {
    $this->get('/who-we-are');

    $response = $this->withHeader('referer', url('/who-we-are'))->get('/language/af');

    $response->assertRedirect('/who-we-are');
});

it('returns 404 for an unsupported locale', function () {
    $this->get('/language/fr')->assertNotFound();
});

it('falls back to English for a model field with no translation', function () {
    $article = Article::factory()->create(['title' => ['en' => 'English Only Title']]);

    $this->withCookie('locale', 'zu')
        ->get(route('articles.show', $article))
        ->assertOk()
        ->assertSee('English Only Title');
});

it('resolves a translated model field under its own locale and falls back for others', function () {
    $article = Article::factory()->create([
        'title' => ['en' => 'English Title', 'zu' => 'Isihloko SesiZulu'],
    ]);

    $this->get(route('articles.show', $article))->assertSee('English Title');

    $this->withCookie('locale', 'zu')
        ->get(route('articles.show', $article))
        ->assertSee('Isihloko SesiZulu')
        ->assertDontSee('English Title');

    $this->withCookie('locale', 'af')
        ->get(route('articles.show', $article))
        ->assertSee('English Title');
});

it('keeps the admin panel in English regardless of the public locale cookie', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->withCookie('locale', 'zu')
        ->get(route('admin.dashboard'))
        ->assertOk()
        ->assertSee('Dashboard')
        ->assertDontSee('lang="zu"', false);
});
