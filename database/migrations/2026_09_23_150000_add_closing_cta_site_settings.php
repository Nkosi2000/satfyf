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
     *
     * Backfills the home page's closing "Ready to speak up?" CTA
     * (previously hardcoded in resources/views/pages/home.blade.php) as
     * admin-editable site settings.
     */
    public function up(): void
    {
        $settings = [
            'closing_cta_heading' => ['en' => 'Ready to speak up?'],
            'closing_cta_body' => ['en' => 'There is no membership fee, and no single way in. Start a Think Session, become a Youth Ambassador, or just tell us what you\'d like to do.'],
        ];

        foreach ($settings as $key => $locales) {
            SiteSetting::query()->firstOrCreate(
                ['key' => $key],
                ['group' => 'closing_cta', 'value' => json_encode($locales)],
            );
        }

        SiteSetting::forgetCache();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        SiteSetting::query()->where('group', 'closing_cta')->delete();

        SiteSetting::forgetCache();
    }
};
