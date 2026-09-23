<?php

use App\Models\SiteSetting;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * firstOrCreate() wraps its insert in a SAVEPOINT (Laravel's
     * race-safe createOrFirst()). Neon's pooled (PgBouncer
     * transaction-mode) connection doesn't reliably support a SAVEPOINT
     * nested inside the migration runner's own transaction — see
     * .ai/rules/general.md and 2026_09_11_172613_make_site_settings_translatable.
     * Disabling the wrapping transaction here makes firstOrCreate()'s
     * call its own top-level (real) transaction instead of a nested one.
     */
    public $withinTransaction = false;

    /**
     * Run the migrations.
     *
     * Backfills the partners marquee's "Trusted by" heading (previously
     * hardcoded in resources/views/pages/home.blade.php) as an
     * admin-editable site setting, in the same "partners" group the
     * public partners page already uses (see PartnerController).
     */
    public function up(): void
    {
        SiteSetting::query()->firstOrCreate(
            ['key' => 'trusted_by_heading'],
            ['group' => 'partners', 'value' => json_encode(['en' => 'Trusted by'])],
        );

        SiteSetting::forgetCache();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        SiteSetting::query()->where('key', 'trusted_by_heading')->delete();

        SiteSetting::forgetCache();
    }
};
