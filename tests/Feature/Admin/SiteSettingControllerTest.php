<?php

use App\Models\SiteSetting;
use App\Models\User;
use Database\Seeders\SiteSettingSeeder;

beforeEach(function () {
    $this->admin = User::factory()->admin()->create();
});

it('redirects guests away from the settings page', function () {
    $this->get(route('admin.organisation.edit', ['page' => 'mission']))->assertRedirect(route('admin.login'));
});

it('404s for an unknown settings page slug', function () {
    $this->actingAs($this->admin)
        ->get(route('admin.pages.edit', ['page' => 'not-a-real-page']))
        ->assertNotFound();
});

it('404s when a page is requested under the wrong section prefix', function () {
    // "mission" belongs to the "organisation" section, not "pages".
    $this->actingAs($this->admin)
        ->get(route('admin.pages.edit', ['page' => 'mission']))
        ->assertNotFound();
});

describe('edit', function () {
    it('lists sections and fields in the order they appear on the public page', function () {
        $this->seed(SiteSettingSeeder::class);

        $this->actingAs($this->admin)
            ->get(route('admin.pages.edit', ['page' => 'home']))
            ->assertOk()
            ->assertSeeInOrder([
                'settings[overview]',
                'settings[why_it_matters_eyebrow]',
                'settings[why_it_matters_heading]',
                'settings[why_it_matters_tab_1]',
                'settings[trusted_by_heading]',
                'settings[closing_cta_heading]',
                'settings[closing_cta_body]',
                'settings[hero_heading]',
                'settings[hero_closing_subtext]',
            ], false);

        $this->actingAs($this->admin)
            ->get(route('admin.pages.edit', ['page' => 'who-we-are']))
            ->assertOk()
            ->assertSeeInOrder([
                'settings[who_we_are_hero_eyebrow]',
                'settings[who_we_are_hero_heading]',
                'settings[who_we_are_hero_subtext]',
                'settings[who_we_are_vision_eyebrow]',
                'settings[youth_chapters_eyebrow]',
                'settings[champions_network_heading]',
            ], false);
    });

    it('has a website-order position for every seeded setting', function () {
        $this->seed(SiteSettingSeeder::class);

        foreach (config('site_setting_pages') as $page => $config) {
            if (! isset($config['fields'])) {
                continue;
            }

            $keys = SiteSetting::query()->whereIn('group', $config['groups'])->pluck('key');

            expect($keys->diff($config['fields'])->values()->all())->toBe([], "Unordered settings on the {$page} page");
        }
    });

    it('renders an icon dropdown for vision icon settings', function () {
        SiteSetting::query()->updateOrCreate(
            ['key' => 'vision_2030_1_icon'],
            ['group' => 'mission', 'value' => json_encode(['en' => 'shield'])],
        );

        $this->actingAs($this->admin)
            ->get(route('admin.organisation.edit', ['page' => 'mission']))
            ->assertOk()
            ->assertSee('name="settings[vision_2030_1_icon][en]"', false)
            ->assertSee('<option value="shield" selected', false);
    });

    it('only shows settings belonging to the requested page', function () {
        // contact_address/overview are normally seeded by
        // SiteSettingSeeder, which RefreshDatabase doesn't run — create
        // them directly so this test only depends on migrated schema.
        SiteSetting::query()->updateOrCreate(['key' => 'contact_address'], ['group' => 'contact', 'value' => json_encode(['en' => 'Some Address'])]);
        SiteSetting::query()->updateOrCreate(['key' => 'overview'], ['group' => 'overview', 'value' => json_encode(['en' => 'Some Overview'])]);

        $this->actingAs($this->admin)
            ->get(route('admin.pages.edit', ['page' => 'contact']))
            ->assertOk()
            ->assertSee('Contact Address')
            ->assertDontSee('Some Overview');
    });

    it('shows the overview on the home page screen, not under mission & vision', function () {
        SiteSetting::query()->updateOrCreate(['key' => 'overview'], ['group' => 'overview', 'value' => json_encode(['en' => 'Home overview text'])]);

        $this->actingAs($this->admin)
            ->get(route('admin.pages.edit', ['page' => 'home']))
            ->assertOk()
            ->assertSee('name="settings[overview][en]"', false)
            ->assertSee('Home overview text');

        $this->actingAs($this->admin)
            ->get(route('admin.organisation.edit', ['page' => 'mission']))
            ->assertOk()
            ->assertDontSee('name="settings[overview][en]"', false);
    });

    it('shows a breadcrumb trail down to the current page', function () {
        $this->actingAs($this->admin)
            ->get(route('admin.pages.edit', ['page' => 'contact']))
            ->assertOk()
            ->assertSeeInOrder(['Dashboard', 'Pages', 'Contact']);
    });
});

describe('update', function () {
    it('saves the selected icon for a vision setting', function () {
        SiteSetting::query()->updateOrCreate(
            ['key' => 'vision_2030_1_icon'],
            ['group' => 'mission', 'value' => json_encode(['en' => 'target'])],
        );

        $response = $this->actingAs($this->admin)->put(route('admin.organisation.update', ['page' => 'mission']), [
            'settings' => [
                'vision_2030_1_icon' => ['en' => 'shield'],
            ],
        ]);

        $response->assertRedirect(route('admin.organisation.edit', ['page' => 'mission']));
        expect(SiteSetting::get('vision_2030_1_icon'))->toBe('shield');
    });

    it('ignores keys outside the requested page\'s groups', function () {
        SiteSetting::query()->updateOrCreate(['key' => 'contact_address'], ['group' => 'contact', 'value' => json_encode(['en' => 'Old Address'])]);
        SiteSetting::query()->updateOrCreate(['key' => 'overview'], ['group' => 'overview', 'value' => json_encode(['en' => 'Old Overview'])]);

        $response = $this->actingAs($this->admin)->put(route('admin.pages.update', ['page' => 'contact']), [
            'settings' => [
                // contact_address belongs to the "contact" page — allowed.
                'contact_address' => ['en' => 'New Address'],
                // overview belongs to the home page, not "contact" — must be ignored.
                'overview' => ['en' => 'Tampered Overview'],
            ],
        ]);

        $response->assertRedirect(route('admin.pages.edit', ['page' => 'contact']));
        expect(SiteSetting::get('contact_address'))->toBe('New Address');
        expect(SiteSetting::get('overview'))->not->toBe('Tampered Overview');
    });

    it('redirects back to the resource list for an embedded page-header panel', function () {
        $response = $this->actingAs($this->admin)->put(route('admin.settings.update', ['page' => 'articles-page']), [
            'settings' => [
                'articles_page_hero_heading' => ['en' => 'Updated Articles Heading'],
            ],
        ]);

        $response->assertRedirect(route('admin.articles.index'));
        expect(SiteSetting::get('articles_page_hero_heading'))->toBe('Updated Articles Heading');
    });
});
