<?php

use App\Models\SiteSetting;
use App\Models\User;

beforeEach(function () {
    $this->admin = User::factory()->admin()->create();
});

it('redirects guests away from the settings page', function () {
    $this->get(route('admin.settings.edit'))->assertRedirect(route('admin.login'));
});

describe('edit', function () {
    it('renders an icon dropdown for vision icon settings', function () {
        SiteSetting::query()->updateOrCreate(
            ['key' => 'vision_2030_1_icon'],
            ['group' => 'mission', 'value' => json_encode(['en' => 'shield'])],
        );

        $this->actingAs($this->admin)
            ->get(route('admin.settings.edit'))
            ->assertOk()
            ->assertSee('name="settings[vision_2030_1_icon][en]"', false)
            ->assertSee('<option value="shield" selected', false);
    });
});

describe('update', function () {
    it('saves the selected icon for a vision setting', function () {
        SiteSetting::query()->updateOrCreate(
            ['key' => 'vision_2030_1_icon'],
            ['group' => 'mission', 'value' => json_encode(['en' => 'target'])],
        );

        $response = $this->actingAs($this->admin)->put(route('admin.settings.update'), [
            'settings' => [
                'vision_2030_1_icon' => ['en' => 'shield'],
            ],
        ]);

        $response->assertRedirect(route('admin.settings.edit'));
        expect(SiteSetting::get('vision_2030_1_icon'))->toBe('shield');
    });
});
