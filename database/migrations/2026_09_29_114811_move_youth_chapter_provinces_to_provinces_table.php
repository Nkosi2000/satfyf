<?php

use App\Models\Province;
use App\Models\SiteSetting;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Neon's pooled connection can't nest the per-insert transactions inside
     * the migration's own — see .ai/rules/general.md.
     */
    public $withinTransaction = false;

    /**
     * Copy any filled-in youth_chapters_province_N settings into the new
     * provinces table, then drop the old fixed-slot settings.
     */
    public function up(): void
    {
        $keys = ['youth_chapters_province_1', 'youth_chapters_province_2', 'youth_chapters_province_3', 'youth_chapters_province_4'];

        $rows = DB::table('site_settings')->whereIn('key', $keys)->pluck('value', 'key');

        foreach ($keys as $order => $key) {
            $translations = json_decode((string) $rows->get($key), true);
            $name = is_array($translations) ? ($translations['en'] ?? collect($translations)->filter()->first()) : null;

            if (filled($name)) {
                Province::query()->firstOrCreate(['name' => $name], ['order' => $order]);
            }
        }

        DB::table('site_settings')->whereIn('key', $keys)->delete();

        SiteSetting::forgetCache();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        foreach ([1, 2, 3, 4] as $i) {
            SiteSetting::query()->firstOrCreate(
                ['key' => 'youth_chapters_province_'.$i],
                ['group' => 'youth_chapters', 'value' => null],
            );
        }

        SiteSetting::forgetCache();
    }
};
