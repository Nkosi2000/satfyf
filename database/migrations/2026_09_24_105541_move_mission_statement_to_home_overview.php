<?php

use App\Models\SiteSetting;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * firstOrCreate() wraps its insert in a SAVEPOINT, which Neon's pooled
     * connection doesn't reliably support inside the migration runner's own
     * transaction — see .ai/rules/general.md.
     */
    public $withinTransaction = false;

    /**
     * Run the migrations.
     *
     * Renames the "Mission Statement" setting to "Overview" and moves it
     * from Organisation → Mission & Vision to Pages → Home, since the home
     * page is now the only place it appears. The Who We Are hero used to
     * borrow the same text as its subtext, so it gets its own
     * who_we_are_hero_subtext setting, starting from a copy of the current
     * (possibly admin-edited, translated) value so that page doesn't change.
     */
    public function up(): void
    {
        $missionStatement = SiteSetting::query()->where('key', 'mission_statement')->first();

        SiteSetting::query()->firstOrCreate(
            ['key' => 'who_we_are_hero_subtext'],
            ['group' => 'who_we_are', 'value' => $missionStatement?->getRawOriginal('value')],
        );

        if ($missionStatement) {
            $missionStatement->update(['key' => 'overview', 'group' => 'overview']);
        }

        SiteSetting::forgetCache();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        SiteSetting::query()
            ->where('key', 'overview')
            ->update(['key' => 'mission_statement', 'group' => 'mission']);

        SiteSetting::query()->where('key', 'who_we_are_hero_subtext')->delete();

        SiteSetting::forgetCache();
    }
};
