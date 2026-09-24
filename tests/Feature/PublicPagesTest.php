<?php

use App\Models\GoalImage;
use App\Models\Partner;
use App\Models\SiteSetting;
use App\Models\Testimonial;
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
        ->assertSee('https://example.com', false);
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

it('shows published testimonials on the home page', function () {
    Testimonial::factory()->create(['name' => 'Zanele Test', 'quote' => 'This programme changed how I see tobacco.', 'published' => true]);

    $this->get('/')
        ->assertOk()
        ->assertSeeInOrder(['Testimonials', 'What people are saying.'])
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
