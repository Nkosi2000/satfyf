<?php

use App\Models\SiteSetting;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Neon's pooled connection can't nest firstOrCreate()'s savepoints inside
     * the migration's own transaction — see .ai/rules/general.md.
     */
    public $withinTransaction = false;

    /**
     * Content for the secondary-nav pages (SupportPageController). Facts only
     * the organisation can supply — helplines, press contacts, report links,
     * banking details — are left empty so nothing invented is ever shown;
     * the pages hide those blocks until an admin fills them in.
     *
     * @return array<string, array<string, string>>
     */
    public static function settings(): array
    {
        return [
            'quit_support' => [
                'quit_support_hero_eyebrow' => 'Quit Support',
                'quit_support_hero_heading' => "Ready to quit? You don't have to do it alone.",
                'quit_support_hero_subtext' => 'Practical, judgement-free help for young people who want to stop smoking or vaping — and for the friends and family supporting them.',
                'quit_support_steps_eyebrow' => 'Where to start',
                'quit_support_steps_heading' => 'Small steps that work.',
                'quit_support_step_1_title' => 'Pick a quit date',
                'quit_support_step_1_body' => 'Choose a day in the next two weeks and tell someone you trust. A set date turns "one day" into a plan.',
                'quit_support_step_2_title' => 'Know your triggers',
                'quit_support_step_2_body' => 'Notice the moments you reach for a cigarette or vape — stress, friends, boredom — and plan something else for each one.',
                'quit_support_step_3_title' => 'Get support',
                'quit_support_step_3_body' => 'Quitting is easier with help. Talk to a clinic, a counsellor or a helpline, and lean on friends who back your decision.',
                'quit_support_help_eyebrow' => 'Talk to someone',
                'quit_support_help_heading' => 'Help is available.',
                'quit_support_help_body' => "If you're not sure where to start, send us a message and we'll point you to support near you.",
                'quit_support_helpline_1_name' => '',
                'quit_support_helpline_1_contact' => '',
                'quit_support_helpline_2_name' => '',
                'quit_support_helpline_2_contact' => '',
                'quit_support_helpline_3_name' => '',
                'quit_support_helpline_3_contact' => '',
            ],
            'media' => [
                'media_hero_eyebrow' => 'Media & Press',
                'media_hero_heading' => 'For journalists and media.',
                'media_hero_subtext' => 'Press enquiries, interview requests, our latest news and brand assets — everything you need to cover youth-led tobacco control in South Africa.',
                'media_contact_eyebrow' => 'Press enquiries',
                'media_contact_heading' => 'Talk to our media team.',
                'media_contact_body' => 'For interviews, comment or event coverage, reach our media team directly.',
                'media_contact_name' => '',
                'media_contact_email' => '',
                'media_contact_phone' => '',
                'media_news_eyebrow' => 'Latest news',
                'media_news_heading' => 'Recent stories.',
                'media_brand_eyebrow' => 'Brand assets',
                'media_brand_heading' => 'Our logo.',
                'media_brand_body' => "Please use our logo as supplied — don't stretch, recolour or alter it.",
            ],
            'reports' => [
                'reports_hero_eyebrow' => 'Reports & Publications',
                'reports_hero_heading' => 'Our work, on the record.',
                'reports_hero_subtext' => 'Annual reports, research and policy submissions from the South African Tobacco-Free Youth Forum.',
                'reports_list_eyebrow' => 'Publications',
                'reports_list_heading' => 'Read and download.',
                ...collect(range(1, 6))->flatMap(fn (int $i): array => [
                    "reports_item_{$i}_title" => '',
                    "reports_item_{$i}_body" => '',
                    "reports_item_{$i}_url" => '',
                ])->all(),
            ],
            'volunteer' => [
                'volunteer_hero_eyebrow' => 'Volunteer',
                'volunteer_hero_heading' => 'Give your time. Change the culture.',
                'volunteer_hero_subtext' => 'Volunteers help run our think sessions, school visits and community events. No experience needed — just commitment.',
                'volunteer_roles_eyebrow' => 'Ways to help',
                'volunteer_roles_heading' => 'Find your role.',
                'volunteer_role_1_title' => 'Youth Ambassador',
                'volunteer_role_1_body' => 'Lead conversations about tobacco and vaping in your school or community, with training and support from our team.',
                'volunteer_role_2_title' => 'Event Volunteer',
                'volunteer_role_2_body' => 'Help plan and run think sessions, Imbizos and public demonstrations in your area.',
                'volunteer_role_3_title' => 'Skills Volunteer',
                'volunteer_role_3_body' => 'Offer professional skills — design, writing, photography, research or social media — to strengthen our campaigns.',
                'volunteer_form_eyebrow' => 'Sign up',
                'volunteer_form_heading' => "Tell us how you'd like to help.",
            ],
            'donate' => [
                'donate_hero_eyebrow' => 'Donate',
                'donate_hero_heading' => 'Fund a tobacco-free generation.',
                'donate_hero_subtext' => 'Your support helps young people reach their peers with the facts — in schools, communities and online.',
                'donate_impact_eyebrow' => 'Your impact',
                'donate_impact_heading' => 'Where your support goes.',
                'donate_impact_1_title' => 'Youth training',
                'donate_impact_1_body' => 'Equips youth ambassadors to lead tobacco-free conversations in their schools and communities.',
                'donate_impact_2_title' => 'Community events',
                'donate_impact_2_body' => 'Funds think sessions, Imbizos and awareness campaigns across the provinces.',
                'donate_impact_3_title' => 'Resources',
                'donate_impact_3_body' => 'Produces fact sheets, toolkits and campaign materials that are free for anyone to use.',
                'donate_bank_eyebrow' => 'Banking details',
                'donate_bank_heading' => 'Give by EFT.',
                'donate_bank_account_name' => '',
                'donate_bank_name' => '',
                'donate_bank_account_number' => '',
                'donate_bank_branch_code' => '',
                'donate_bank_reference' => '',
                'donate_form_eyebrow' => 'Partner with us',
                'donate_form_heading' => 'Other ways to give.',
            ],
        ];
    }

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        foreach (self::settings() as $group => $pairs) {
            foreach ($pairs as $key => $value) {
                SiteSetting::query()->firstOrCreate(
                    ['key' => $key],
                    ['group' => $group, 'value' => $value === '' ? null : json_encode(['en' => $value])],
                );
            }
        }

        SiteSetting::forgetCache();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        SiteSetting::query()->whereIn('group', array_keys(self::settings()))->delete();

        SiteSetting::forgetCache();
    }
};
