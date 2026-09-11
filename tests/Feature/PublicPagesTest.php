<?php

use App\Models\Partner;

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
]);

it('renders the partners page grouped by type', function () {
    Partner::factory()->create(['name' => 'Test Partner Org', 'type' => 'partner', 'published' => true]);

    $this->get('/partners')
        ->assertOk()
        ->assertSee('Test Partner Org');
});

it('does not show unpublished partners', function () {
    Partner::factory()->create(['name' => 'Hidden Org', 'published' => false]);

    $this->get('/partners')
        ->assertOk()
        ->assertDontSee('Hidden Org');
});
