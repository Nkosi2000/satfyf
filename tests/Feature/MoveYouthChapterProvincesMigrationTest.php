<?php

use App\Models\Province;
use App\Models\SiteSetting;

it('copies filled-in youth chapter province settings into provinces and removes the old settings', function () {
    SiteSetting::query()->create(['key' => 'youth_chapters_province_1', 'group' => 'youth_chapters', 'value' => json_encode(['en' => 'Gauteng'])]);
    SiteSetting::query()->create(['key' => 'youth_chapters_province_2', 'group' => 'youth_chapters', 'value' => null]);
    SiteSetting::query()->create(['key' => 'youth_chapters_province_3', 'group' => 'youth_chapters', 'value' => json_encode(['en' => 'Limpopo'])]);

    $migration = require database_path('migrations/2026_09_29_114811_move_youth_chapter_provinces_to_provinces_table.php');
    $migration->up();

    expect(Province::query()->ordered()->pluck('name')->all())->toBe(['Gauteng', 'Limpopo'])
        ->and(SiteSetting::query()->where('key', 'like', 'youth_chapters_province_%')->count())->toBe(0);
});
