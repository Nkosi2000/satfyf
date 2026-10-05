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
     * @var array<string, string>
     */
    private array $settings = [
        'what_we_do_milestone_eyebrow' => 'Our First Milestone',
        'what_we_do_milestone_heading' => 'What we do',
        'what_we_do_milestone_paragraph_1' => 'As the forum, our first biggest milestone is to support the global treaty of the WHO Framework Convention on Tobacco Control by means of advocating for the passing of the Control of Tobacco Products and Electronic Delivery Systems Bill of 2022 in South Africa.',
        'what_we_do_milestone_paragraph_2' => 'To achieve this, SATFYF is mobilising and encouraging passionate youth to stand with us in advocating for the speedy processing of the Tobacco Control Bill. With advocacy campaigns being one of the best actions used in getting our voices heard, we’re working with youth advocates and Youth Ambassadors in amplifying our call for Policy Makers and the President of South Africa to take notice and recognise the importance of passing the Tobacco Control Bill.',
    ];

    /**
     * Run the migrations.
     *
     * Backfills the What We Do page's milestone section (shown below the
     * hero, beside its own image slideshow) as admin-editable site settings.
     */
    public function up(): void
    {
        foreach ($this->settings as $key => $value) {
            SiteSetting::query()->firstOrCreate(
                ['key' => $key],
                ['group' => 'what_we_do', 'value' => json_encode(['en' => $value])],
            );
        }

        SiteSetting::forgetCache();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        SiteSetting::query()->whereIn('key', array_keys($this->settings))->delete();

        SiteSetting::forgetCache();
    }
};
