<?php

use App\Models\SiteSetting;
use App\Models\User;

function setSupportPageSetting(string $key, string $value): void
{
    SiteSetting::query()->where('key', $key)->update(['value' => json_encode(['en' => $value])]);
    SiteSetting::forgetCache();
}

it('renders each secondary nav page with its default content', function (string $routeName, string $expectedHeading) {
    $this->get(route($routeName))
        ->assertOk()
        ->assertSee($expectedHeading, false);
})->with([
    'quit support' => ['quit-support', 'Ready to quit? You don&#039;t have to do it alone.'],
    'media' => ['media', 'For journalists and media.'],
    'reports' => ['reports', 'Our work, on the record.'],
    'volunteer' => ['volunteer', 'Give your time. Change the culture.'],
    'donate' => ['donate', 'Fund a tobacco-free generation.'],
]);

it('links every secondary nav page from the site header', function () {
    $this->get(route('home'))
        ->assertOk()
        ->assertSee('data-secondary-nav-toggle', false)
        ->assertSee('href="'.route('quit-support').'"', false)
        ->assertSee('href="'.route('media').'"', false)
        ->assertSee('href="'.route('reports').'"', false)
        ->assertSee('href="'.route('volunteer').'"', false)
        ->assertSee('href="'.route('donate').'"', false);
});

it('lists every secondary nav page in the footer', function () {
    $footer = str($this->get(route('home'))->assertOk()->getContent())->after('<footer');

    foreach (['quit-support', 'media', 'reports', 'volunteer', 'donate'] as $routeName) {
        expect((string) $footer)->toContain('href="'.route($routeName).'"');
    }
});

it('highlights the donate link in red in the secondary nav', function () {
    $html = $this->get(route('home'))->assertOk()->getContent();

    expect($html)->toMatch('/<a\s+href="'.preg_quote(route('donate'), '/').'"\s+class="[^"]*text-danger[^"]*"/');
});

it('hides banking details until an account number is entered', function () {
    $this->get(route('donate'))->assertDontSee('Give by EFT.');

    setSupportPageSetting('donate_bank_account_number', '1234567890');

    $this->get(route('donate'))
        ->assertSee('Give by EFT.')
        ->assertSee('1234567890');
});

it('lists a helpline once an admin adds one', function () {
    setSupportPageSetting('quit_support_helpline_1_name', 'Quit Line');
    setSupportPageSetting('quit_support_helpline_1_contact', '0800 000 000');

    $this->get(route('quit-support'))
        ->assertSee('Quit Line')
        ->assertSee('0800 000 000');
});

it('shows an empty state on reports until a publication is added', function () {
    $this->get(route('reports'))->assertSee('Publications will be listed here soon.');

    setSupportPageSetting('reports_item_1_title', 'Annual Report 2025');
    setSupportPageSetting('reports_item_1_url', 'https://example.com/annual-report.pdf');

    $this->get(route('reports'))
        ->assertDontSee('Publications will be listed here soon.')
        ->assertSee('Annual Report 2025')
        ->assertSee('https://example.com/annual-report.pdf', false);
});

it('prefills the volunteer form subject from the chosen role', function () {
    $this->get(route('volunteer', ['interest' => 'Event Volunteer']))
        ->assertOk()
        ->assertSee('value="Event Volunteer"', false);
});

it('lets an admin edit a secondary nav page\'s content', function (string $page, string $field) {
    $this->actingAs(User::factory()->admin()->create())
        ->get(route('admin.pages.edit', ['page' => $page]))
        ->assertOk()
        ->assertSee("settings[{$field}]", false);
})->with([
    ['quit-support', 'quit_support_helpline_1_contact'],
    ['media', 'media_contact_email'],
    ['reports', 'reports_item_1_url'],
    ['volunteer', 'volunteer_role_1_title'],
    ['donate', 'donate_bank_account_number'],
]);
