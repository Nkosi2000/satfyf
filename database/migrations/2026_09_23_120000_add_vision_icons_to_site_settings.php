<?php

use App\Models\SiteSetting;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $icons = [
            'vision_2030_1_icon' => 'users',
            'vision_2030_2_icon' => 'book',
            'vision_2030_3_icon' => 'shield',
        ];

        foreach ($icons as $key => $icon) {
            SiteSetting::query()->firstOrCreate(
                ['key' => $key],
                ['group' => 'mission', 'value' => json_encode(['en' => $icon])],
            );
        }

        SiteSetting::forgetCache();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        SiteSetting::query()->whereIn('key', [
            'vision_2030_1_icon',
            'vision_2030_2_icon',
            'vision_2030_3_icon',
        ])->delete();

        SiteSetting::forgetCache();
    }
};
