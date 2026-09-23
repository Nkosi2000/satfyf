<?php

use App\Models\Partner;
use App\Models\SiteSetting;
use App\Models\Testimonial;

it('renders each simple public page successfully', function (string $uri, string $expectedText) {
    $this->get($uri)
        ->assertOk()
        ->assertSee($expectedText);
})->with([
    'home' => ['/', 'South African Tobacco-Free Youth Forum'],
    'who we are' => ['/who-we-are', 'Youth voices, not youth audiences.'],
    'why we exist' => ['/why-we-exist', "Tobacco doesn't market itself to adults."],
    'what we do' => ['/what-we-do', 'Every programme, grouped by purpose.'],
    'gallery' => ['/gallery', 'SATFYF, in the field.'],
    'get involved' => ['/get-involved', 'Help achieve a culture where young people reject tobacco.'],
    'contact' => ['/contact', "Let's talk."],
    'privacy' => ['/privacy', 'What we store, and why.'],
]);

it('renders the no-smoking animation canvas below the Why We Exist heading', function () {
    $this->get('/')
        ->assertOk()
        ->assertSee('data-lottie="'.asset('images/no smoking.lottie').'"', false);
});

it('renders the partners page grouped by type', function () {
    Partner::factory()->create(['name' => 'Test Partner Org', 'type' => 'partner', 'published' => true]);

    $this->get('/partners')
        ->assertOk()
        ->assertSee('Test Partner Org');
});

it('shows a partner\'s role, description and website link on the partners page', function () {
    Partner::factory()->create([
        'name' => 'Test Partner Org',
        'role' => 'Funds youth ambassador training',
        'description' => 'A short blurb about what this partner does for SATFYF.',
        'url' => 'https://example.com',
        'published' => true,
    ]);

    $this->get('/partners')
        ->assertOk()
        ->assertSee('Funds youth ambassador training')
        ->assertSee('A short blurb about what this partner does for SATFYF.')
        ->assertSee('https://example.com', false);
});

it('does not show unpublished partners', function () {
    Partner::factory()->create(['name' => 'Hidden Org', 'published' => false]);

    $this->get('/partners')
        ->assertOk()
        ->assertDontSee('Hidden Org');
});

it('shows published testimonials on the home page', function () {
    Testimonial::factory()->create(['name' => 'Zanele Test', 'quote' => 'This programme changed how I see tobacco.', 'published' => true]);

    $this->get('/')
        ->assertOk()
        ->assertSee('Zanele Test')
        ->assertSee('This programme changed how I see tobacco.');
});

it('does not show unpublished testimonials on the home page', function () {
    Testimonial::factory()->create(['name' => 'Hidden Voice', 'published' => false]);

    $this->get('/')
        ->assertOk()
        ->assertDontSee('Hidden Voice');
});

it('renders the admin-selected icon for each vision on the home page', function () {
    SiteSetting::query()->updateOrCreate(
        ['key' => 'vision_2030_1_icon'],
        ['group' => 'mission', 'value' => json_encode(['en' => 'megaphone'])],
    );

    $this->get('/')
        ->assertOk()
        ->assertSee('data-icon="megaphone"', false);
});

it('falls back to the target icon when a vision has no icon selected', function () {
    SiteSetting::query()->updateOrCreate(
        ['key' => 'vision_2030_1_icon'],
        ['group' => 'mission', 'value' => null],
    );

    $this->get('/')
        ->assertOk()
        ->assertSee('data-icon="target"', false);
});

it('prefills the get-involved contact subject from the interest query parameter', function () {
    $this->get('/get-involved?interest=Become a Youth Ambassador')
        ->assertOk()
        ->assertSee('value="Become a Youth Ambassador"', false);
});
