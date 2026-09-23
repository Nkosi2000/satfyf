<?php

use App\Models\SiteSetting;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * firstOrCreate() wraps its insert in a SAVEPOINT (Laravel's
     * race-safe createOrFirst()). Neon's pooled (PgBouncer
     * transaction-mode) connection doesn't reliably support a SAVEPOINT
     * nested inside the migration runner's own transaction — see the
     * identical DDL note on 2026_09_11_172613_make_site_settings_translatable.
     * Disabling the wrapping transaction here makes each firstOrCreate()
     * call its own top-level (real) transaction instead of a nested one.
     */
    public $withinTransaction = false;

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
