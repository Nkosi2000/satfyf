<?php

use App\Models\SiteSetting;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
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
