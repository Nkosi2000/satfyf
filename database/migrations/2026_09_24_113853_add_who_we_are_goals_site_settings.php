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
        'who_we_are_goals_heading' => 'SATFYF Goals & Objectives',
        'who_we_are_goals_intro' => 'Our main goal is to EDUCATE, INFORM and INFLUENCE CHANGE through:',
        'who_we_are_goal_1' => 'Creating A Formidable Youth Tobacco-Control Movement In South Africa',
        'who_we_are_goal_2' => 'Educating & Informing Young People About The Harsh Realities And The Effects Of Tobacco Through Various Digital And Physical Campaigns.',
        'who_we_are_goal_3' => 'Gaining Support & Putting Pressure On The Government To Process The Tobacco-Control Bill Through Various Legislative Stages.',
        'who_we_are_goal_4' => 'Disengaging The Tobacco Industry Through Persuasive Communications & Media Outreach Activities.',
    ];

    /**
     * Run the migrations.
     *
     * Backfills the Who We Are page's new "Goals & Objectives" section
     * (shown below the org motto) as admin-editable site settings.
     */
    public function up(): void
    {
        foreach ($this->settings as $key => $value) {
            SiteSetting::query()->firstOrCreate(
                ['key' => $key],
                ['group' => 'who_we_are', 'value' => json_encode(['en' => $value])],
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
