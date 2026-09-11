<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            'hero' => [
                'hero_eyebrow' => 'South African Tobacco-Free Youth Forum',
                'hero_heading' => 'Speak up. Stand out.',
                'hero_heading_accent' => 'A smoke-free generation.',
                'hero_subtext' => 'We are the youth voices championing and fighting against the harsh and dangerous realities of tobacco, substance and drug abuse amongst young people.',
            ],
            'mission' => [
                'mission_tagline' => 'We speak and spread the truth about smoking.',
                'mission_statement' => 'Youth voices championing & fighting against the harsh and dangerous realities of tobacco, as well as substance & drug abuse amongst young people.',
                'vision_2030_1' => 'Young people reject smoking in social settings.',
                'vision_2030_2' => 'Every educational institution is smoke-free.',
                'vision_2030_3' => 'Youth confidently decline every tobacco offer.',
            ],
            'contact' => [
                'contact_address' => 'Corporate Park 66, 66 Von Willich Ave, Die Hoewes, Centurion, Pretoria, South Africa 0163',
                'contact_phone_office' => '012-440-1325',
                'contact_phone_mobile' => '064-503-4334',
                'contact_email' => 'info@satfyf.org.za',
            ],
            'social' => [
                'social_facebook' => 'https://facebook.com/SATFYF2030',
                'social_instagram' => 'https://instagram.com/satfyf2030',
                'social_twitter' => 'https://twitter.com/satfyf2030',
                'social_youtube' => 'https://youtube.com/@satfyf2030',
            ],
            'footer' => [
                'footer_tagline' => 'A smoke free generation in our lifetime.',
            ],
        ];

        foreach ($settings as $group => $pairs) {
            foreach ($pairs as $key => $value) {
                SiteSetting::query()->updateOrCreate(
                    ['key' => $key],
                    ['group' => $group, 'value' => json_encode(['en' => $value])],
                );
            }
        }
    }
}
