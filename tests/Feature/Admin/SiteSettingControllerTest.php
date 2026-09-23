<?php

use App\Models\SiteSetting;
use App\Models\User;

beforeEach(function () {
    $this->admin = User::factory()->admin()->create();
});

it('redirects guests away from the settings page', function () {
    $this->get(route('admin.settings.edit', ['page' => 'mission']))->assertRedirect(route('admin.login'));
});

it('404s for an unknown settings page slug', function () {
    $this->actingAs($this->admin)
        ->get(route('admin.settings.edit', ['page' => 'not-a-real-page']))
        ->assertNotFound();
});

describe('edit', function () {
    it('renders an icon dropdown for vision icon settings', function () {
        SiteSetting::query()->updateOrCreate(
            ['key' => 'vision_2030_1_icon'],
            ['group' => 'mission', 'value' => json_encode(['en' => 'shield'])],
        );

        $this->actingAs($this->admin)
            ->get(route('admin.settings.edit', ['page' => 'mission']))
            ->assertOk()
            ->assertSee('name="settings[vision_2030_1_icon][en]"', false)
            ->assertSee('<option value="shield" selected', false);
    });

    it('only shows settings belonging to the requested page', function () {
        // contact_address/mission_statement are normally seeded by
        // SiteSettingSeeder, which RefreshDatabase doesn't run — create
        // them directly so this test only depends on migrated schema.
        SiteSetting::query()->updateOrCreate(['key' => 'contact_address'], ['group' => 'contact', 'value' => json_encode(['en' => 'Some Address'])]);
        SiteSetting::query()->updateOrCreate(['key' => 'mission_statement'], ['group' => 'mission', 'value' => json_encode(['en' => 'Some Statement'])]);

        $this->actingAs($this->admin)
            ->get(route('admin.settings.edit', ['page' => 'contact']))
            ->assertOk()
            ->assertSee('Contact Address')
            ->assertDontSee('Mission Statement');
    });
});

describe('update', function () {
    it('saves the selected icon for a vision setting', function () {
        SiteSetting::query()->updateOrCreate(
            ['key' => 'vision_2030_1_icon'],
            ['group' => 'mission', 'value' => json_encode(['en' => 'target'])],
        );

        $response = $this->actingAs($this->admin)->put(route('admin.settings.update', ['page' => 'mission']), [
            'settings' => [
                'vision_2030_1_icon' => ['en' => 'shield'],
            ],
        ]);

        $response->assertRedirect(route('admin.settings.edit', ['page' => 'mission']));
        expect(SiteSetting::get('vision_2030_1_icon'))->toBe('shield');
    });

    it('ignores keys outside the requested page\'s groups', function () {
        SiteSetting::query()->updateOrCreate(['key' => 'contact_address'], ['group' => 'contact', 'value' => json_encode(['en' => 'Old Address'])]);
        SiteSetting::query()->updateOrCreate(['key' => 'mission_statement'], ['group' => 'mission', 'value' => json_encode(['en' => 'Old Statement'])]);

        $response = $this->actingAs($this->admin)->put(route('admin.settings.update', ['page' => 'contact']), [
            'settings' => [
                // contact_address belongs to the "contact" page — allowed.
                'contact_address' => ['en' => 'New Address'],
                // mission_statement belongs to "mission", not "contact" — must be ignored.
                'mission_statement' => ['en' => 'Tampered Statement'],
            ],
        ]);

        $response->assertRedirect(route('admin.settings.edit', ['page' => 'contact']));
        expect(SiteSetting::get('contact_address'))->toBe('New Address');
        expect(SiteSetting::get('mission_statement'))->not->toBe('Tampered Statement');
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
