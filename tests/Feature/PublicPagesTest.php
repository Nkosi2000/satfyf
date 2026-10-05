<?php

use App\Models\Article;
use App\Models\EventItem;
use App\Models\GoalImage;
use App\Models\Partner;
use App\Models\Province;
use App\Models\SiteSetting;
use App\Models\Testimonial;
use App\Models\WhatWeDoImage;
use Illuminate\Support\Facades\Storage;

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

it('renders the site-wide fluid smoke backdrop', function () {
    $this->get('/')
        ->assertOk()
        ->assertSee('data-fluid-smoke', false);
});

it('renders the ticker strip directly below the home hero', function () {
    $html = $this->get('/')->assertOk()->getContent();

    expect($html)->toMatch('/<section data-home-hero.*?<\/section>\s*(?:<!--.*?-->\s*)?<div data-hero-ticker/s');
});

it('renders the home hero copy beside the spinning brand coin', function () {
    $this->get('/')
        ->assertOk()
        ->assertSeeInOrder([
            'data-home-hero',
            __('Speak up. Stand out.'),
            __('Get Involved'),
            'hero-coin-front',
            'images/hero-fist.png',
            'hero-coin-back',
            __('Our Vision'),
        ], false);
});

it('renders the brand triangle pattern in inner page heroes and the footer', function () {
    $this->get('/who-we-are')
        ->assertOk()
        ->assertSee('triangle-pattern--top-right', false)
        ->assertSee('triangle-pattern--bottom-left', false);
});

it('gives each nav link its own underline colour', function () {
    $html = $this->get('/')->assertOk()->getContent();

    $underlineColorFor = function (string $label) use ($html): ?string {
        preg_match('/'.preg_quote($label, '/').'\s*<span data-nav-underline[^>]*style="background-color: ([^"]+)"/', $html, $matches);

        return $matches[1] ?? null;
    };

    expect($underlineColorFor('Home'))->toBe('var(--color-brand-red)')
        ->and($underlineColorFor('Who We Are'))->toBe('var(--color-green)')
        ->and($underlineColorFor('Why We Exist'))->toBe('var(--color-tertiary)')
        ->and($underlineColorFor('Donate'))->toBe('var(--color-brand-red)')
        ->and(substr_count($html, 'data-nav-underline'))->toBe(15);
});

it('draws section dividers in the brand gradient', function () {
    $this->get('/who-we-are')
        ->assertOk()
        ->assertSee('class="section-divider', false)
        ->assertDontSee('<section class="hairline-t', false);
});

it('spreads the triangle pattern across the home page sections', function () {
    $html = $this->get('/')->assertOk()->getContent();

    expect(substr_count($html, 'data-triangle-pattern'))->toBeGreaterThanOrEqual(6);
});

it('renders the no-smoking animation canvas below the Why We Exist heading', function () {
    $this->get('/')
        ->assertOk()
        ->assertSee('data-lottie="'.asset('images/No smoking animation.json').'"', false);
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
        ->assertSee('https://example.com', false)
        ->assertSee('Visit Test Partner Org');
});

it('does not show unpublished partners', function () {
    Partner::factory()->create(['name' => 'Hidden Org', 'published' => false]);

    $this->get('/partners')
        ->assertOk()
        ->assertDontSee('Hidden Org');
});

it('shows the overview on the home page but not on who we are', function () {
    SiteSetting::query()->updateOrCreate(['key' => 'overview'], ['group' => 'overview', 'value' => json_encode(['en' => 'Home-only overview text.'])]);
    SiteSetting::query()->updateOrCreate(['key' => 'who_we_are_hero_subtext'], ['group' => 'who_we_are', 'value' => json_encode(['en' => 'Who we are subtext.'])]);

    $this->get('/')
        ->assertOk()
        ->assertSee('Home-only overview text.');

    $this->get('/who-we-are')
        ->assertOk()
        ->assertSee('Who we are subtext.')
        ->assertDontSee('Home-only overview text.');
});

it('shows the goals and objectives section with its slideshow on who we are', function () {
    SiteSetting::query()->updateOrCreate(['key' => 'who_we_are_goals_heading'], ['group' => 'who_we_are', 'value' => json_encode(['en' => 'SATFYF Goals & Objectives'])]);
    SiteSetting::query()->updateOrCreate(['key' => 'who_we_are_goal_1'], ['group' => 'who_we_are', 'value' => json_encode(['en' => 'Creating a youth movement'])]);
    GoalImage::factory()->create(['caption' => 'First slide', 'order' => 0]);
    GoalImage::factory()->create(['caption' => 'Second slide', 'order' => 1]);

    $this->get('/who-we-are')
        ->assertOk()
        ->assertSeeInOrder(['SATFYF Goals &amp; Objectives', 'Creating a youth movement', 'alt="First slide"', 'alt="Second slide"'], false)
        ->assertSee('data-crossfade-toggle', false);
});

it('shows the goals section without a slideshow when no images are uploaded', function () {
    SiteSetting::query()->updateOrCreate(['key' => 'who_we_are_goals_heading'], ['group' => 'who_we_are', 'value' => json_encode(['en' => 'SATFYF Goals & Objectives'])]);

    $this->get('/who-we-are')
        ->assertOk()
        ->assertSee('SATFYF Goals &amp; Objectives', false)
        ->assertDontSee('data-crossfade', false);
});

it('lists admin-managed provinces in order under youth chapters on who we are', function () {
    Province::factory()->create(['name' => 'Western Cape', 'order' => 2]);
    Province::factory()->create(['name' => 'Gauteng', 'order' => 1]);

    $this->get('/who-we-are')
        ->assertOk()
        ->assertSeeInOrder(['Active across the country.', 'Gauteng', 'Western Cape']);
});

it('hides the youth chapters section when there is no intro and no provinces', function () {
    $this->get('/who-we-are')
        ->assertOk()
        ->assertDontSee('Active across the country.');
});

it('shows published testimonials on the home page', function () {
    Testimonial::factory()->create(['name' => 'Zanele Test', 'quote' => 'This programme changed how I see tobacco.', 'published' => true]);

    $this->get('/')
        ->assertOk()
        ->assertSeeInOrder(['Testimonials', 'What people are saying.'])
        ->assertSee('Zanele Test')
        ->assertSee('This programme changed how I see tobacco.');
});

it('links the latest articles and upcoming events on the home page', function () {
    $article = Article::factory()->create(['title' => 'Youth Summit Recap', 'published_at' => now()->subDay()]);
    $event = EventItem::factory()->create(['title' => 'Cape Town Workshop', 'starts_at' => now()->addWeek()]);

    $this->get('/')
        ->assertOk()
        ->assertSee('href="'.route('articles.show', $article).'"', false)
        ->assertSee('Youth Summit Recap')
        ->assertSee('href="'.route('events.show', $event).'"', false)
        ->assertSee('Cape Town Workshop');
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

it('renders the admin-editable Why It Matters tabs on the home page', function () {
    $this->get('/')
        ->assertOk()
        ->assertSee('Why It Matters')
        ->assertSee('More than awareness.')
        ->assertSee('Youth-led')
        ->assertSee('Every campaign, think session and demonstration is planned and led by young people themselves, not adults speaking on their behalf.');
});

it('reflects an admin edit to a Why It Matters tab on the home page', function () {
    SiteSetting::query()->updateOrCreate(
        ['key' => 'why_it_matters_tab_1'],
        ['group' => 'why_it_matters', 'value' => json_encode(['en' => 'Custom Tab Label'])],
    );

    $this->get('/')
        ->assertOk()
        ->assertSee('Custom Tab Label');
});

it('renders the admin-editable closing CTA on the home page', function () {
    $this->get('/')
        ->assertOk()
        ->assertSee('Ready to speak up?')
        ->assertSee('There is no membership fee, and no single way in. Start a Think Session, become a Youth Ambassador, or just tell us what you\'d like to do.');
});

it('reflects an admin edit to the closing CTA on the home page', function () {
    SiteSetting::query()->updateOrCreate(
        ['key' => 'closing_cta_heading'],
        ['group' => 'closing_cta', 'value' => json_encode(['en' => 'Custom CTA Heading'])],
    );

    $this->get('/')
        ->assertOk()
        ->assertSee('Custom CTA Heading');
});

it('renders the admin-editable Trusted By heading on the home page', function () {
    Storage::fake('public');
    Storage::disk('public')->buildTemporaryUrlsUsing(fn ($path, $expiration) => Storage::disk('public')->url($path));
    Storage::disk('public')->put('partners/logo.png', 'contents');
    Partner::factory()->create(['logo_path' => 'partners/logo.png', 'published' => true]);

    $this->get('/')
        ->assertOk()
        ->assertSee('Trusted by');
});

it('reflects an admin edit to the Trusted By heading on the home page', function () {
    Storage::fake('public');
    Storage::disk('public')->buildTemporaryUrlsUsing(fn ($path, $expiration) => Storage::disk('public')->url($path));
    Storage::disk('public')->put('partners/logo.png', 'contents');
    Partner::factory()->create(['logo_path' => 'partners/logo.png', 'published' => true]);

    SiteSetting::query()->updateOrCreate(
        ['key' => 'trusted_by_heading'],
        ['group' => 'trusted_by', 'value' => json_encode(['en' => 'Custom Trusted Heading'])],
    );

    $this->get('/')
        ->assertOk()
        ->assertSee('Custom Trusted Heading');
});

it('prefills the get-involved contact subject from the interest query parameter', function () {
    $this->get('/get-involved?interest=Become a Youth Ambassador')
        ->assertOk()
        ->assertSee('value="Become a Youth Ambassador"', false);
});

it('pins the saved social profiles to the left edge of every page', function () {
    SiteSetting::query()->updateOrCreate(['key' => 'social_facebook'], ['group' => 'social', 'value' => json_encode(['en' => 'https://facebook.com/SATFYF2030'])]);
    SiteSetting::query()->updateOrCreate(['key' => 'social_instagram'], ['group' => 'social', 'value' => json_encode(['en' => ''])]);

    $html = $this->get('/contact')->assertOk()->getContent();

    expect($html)->toMatch('/<aside\s+data-social-rail.*?href="https:\/\/facebook\.com\/SATFYF2030".*?<\/aside>/s')
        ->and($html)->not->toMatch('/<aside\s+data-social-rail[^>]*>(?:(?!<\/aside>).)*aria-label="Instagram"/s');
});

it('omits the social rail when no social profiles are set', function () {
    SiteSetting::query()->where('group', 'social')->delete();
    SiteSetting::forgetCache();

    $this->get('/contact')->assertOk()->assertDontSee('data-social-rail', false);
});

it('renders the What We Do milestone section with its slideshow on the left', function () {
    WhatWeDoImage::factory()->create(['caption' => 'Youth ambassadors at Parliament', 'order' => 0]);

    $this->get('/what-we-do')
        ->assertOk()
        ->assertSeeInOrder([
            'data-what-we-do-milestone',
            'Youth ambassadors at Parliament',
            'Our First Milestone',
            'What we do',
            'WHO Framework Convention on Tobacco Control',
            'Youth Ambassadors in amplifying our call',
        ], false);
});

it('shows the What We Do milestone copy edited in admin', function () {
    SiteSetting::query()->updateOrCreate(['key' => 'what_we_do_milestone_paragraph_1'], ['group' => 'what_we_do', 'value' => json_encode(['en' => 'Edited milestone copy.'])]);

    $this->get('/what-we-do')
        ->assertOk()
        ->assertSee('Edited milestone copy.')
        ->assertDontSee('WHO Framework Convention on Tobacco Control');
});
