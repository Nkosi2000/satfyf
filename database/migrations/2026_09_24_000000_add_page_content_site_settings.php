<?php

use App\Models\SiteSetting;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * firstOrCreate() wraps its insert in a SAVEPOINT (Laravel's
     * race-safe createOrFirst()). Neon's pooled (PgBouncer
     * transaction-mode) connection doesn't reliably support a SAVEPOINT
     * nested inside the migration runner's own transaction — see
     * .ai/rules/general.md and 2026_09_11_172613_make_site_settings_translatable.
     * Disabling the wrapping transaction here makes each firstOrCreate()
     * call its own top-level (real) transaction instead of a nested one.
     */
    public $withinTransaction = false;

    /**
     * Run the migrations.
     *
     * Finishes converting every remaining hardcoded page (Why We Exist,
     * Get Involved, Who We Are's team/vision blocks, Contact, What We Do,
     * Privacy, plus the Articles/Events/Gallery/Partners/Resources page
     * heroes) into admin-editable SiteSetting rows, and moves
     * `trusted_by_heading` out of the `partners` group into its own
     * `trusted_by` group so `partners` belongs solely to the Partners page.
     *
     * Every key is prefixed with its page/group name even where a bare
     * name (e.g. "hero_eyebrow") would otherwise read fine — `key` carries
     * a *global* unique constraint (not scoped per group), so two groups
     * can never share a bare key name without colliding.
     */
    public function up(): void
    {
        $settings = [
            'why_we_exist' => [
                'why_we_exist_hero_eyebrow' => 'Why We Exist',
                'why_we_exist_hero_heading' => "Tobacco doesn't market itself to adults.",
                'why_we_exist_hero_subtext' => "Tobacco use carries real health harms, real economic costs, and it still starts young. In a country still building the policy and enforcement to protect its youth, silence isn't neutral — it's a gap the industry is glad to fill.",
                'why_we_exist_stat_1_label' => 'Health',
                'why_we_exist_stat_1_body' => "Nicotine takes hold fastest in adolescent brains, and the harms of smoking compound over a lifetime that's only just starting.",
                'why_we_exist_stat_2_label' => 'Economic',
                'why_we_exist_stat_2_body' => 'Every rand spent on tobacco is a rand not spent on education, health or savings — a cost that falls hardest on households that can least afford it.',
                'why_we_exist_stat_3_label' => 'Policy',
                'why_we_exist_stat_3_body' => "South Africa's tobacco control policy is still catching up. Youth voices in that process are what keep it honest and enforced.",
                'why_we_exist_respond_eyebrow' => 'How We Respond',
                'why_we_exist_respond_heading' => "We don't just warn. We show up.",
                'why_we_exist_respond_body' => 'Think sessions, social media conversations, media advocacy, public demonstrations and Community Imbizos — SATFYF meets young people in the spaces they already occupy, with facts instead of fear.',
            ],
            'get_involved' => [
                'get_involved_hero_eyebrow' => 'Get Involved',
                'get_involved_hero_heading' => 'Help achieve a culture where young people reject tobacco.',
                'get_involved_hero_subtext' => "There's no membership fee, and no single way in. Pick what fits.",
                'get_involved_statement' => '',
                'get_involved_join_form_url' => '',
                'get_involved_ways_eyebrow' => 'Ways In',
                'get_involved_ways_heading' => 'Four ways to get involved.',
                'get_involved_way_1_title' => 'Start a Think Session',
                'get_involved_way_1_body' => 'Bring a facilitated conversation about tobacco and substance abuse to your school or youth group.',
                'get_involved_way_2_title' => 'Become a Youth Ambassador',
                'get_involved_way_2_body' => 'Get trained to run campaigns, speak at events and lead in your own community.',
                'get_involved_way_3_title' => 'Host a Community Imbizo',
                'get_involved_way_3_body' => 'Bring parents, teachers and local leaders together for an honest conversation.',
                'get_involved_way_4_title' => 'Partner with SATFYF',
                'get_involved_way_4_body' => 'Organisations and donors — see how a partnership could work.',
                'get_involved_reach_eyebrow' => 'Reach Out',
                'get_involved_reach_heading' => "Tell us what you'd like to do.",
                'get_involved_questions_heading' => 'Questions.',
            ],
            'who_we_are' => [
                'who_we_are_hero_eyebrow' => 'Who We Are',
                'who_we_are_hero_heading' => 'Youth voices, not youth audiences.',
                'who_we_are_vision_eyebrow' => 'Vision 2030',
                'who_we_are_vision_heading' => 'By 2030, we want to see.',
                'who_we_are_team_eyebrow' => 'The Team',
                'who_we_are_team_heading' => 'People behind the forum.',
                'who_we_are_team_body' => 'A small, youth-led core team coordinates chapters and campaigns across the country, backed by volunteers, mentors and partner organisations who help run every Think Session, Imbizo and demonstration on the ground.',
            ],
            // Left empty on purpose: this whole section is gated behind
            // "intro" being non-empty (see who-we-are.blade.php), and it
            // currently renders nothing — seeding it empty keeps that
            // behaviour and just makes it appear in admin ready to fill in.
            'youth_chapters' => [
                'youth_chapters_eyebrow' => '',
                'youth_chapters_heading' => '',
                'youth_chapters_intro' => '',
                'youth_chapters_province_1' => '',
                'youth_chapters_province_2' => '',
                'youth_chapters_province_3' => '',
                'youth_chapters_province_4' => '',
            ],
            // Left empty on purpose: same dead-hook situation, gated behind
            // champions_network_heading being non-empty.
            'champions_network' => [
                'champions_network_heading' => '',
                'champions_network_body' => '',
                'champions_network_cta_label' => '',
                'champions_network_cta_url' => '',
            ],
            'contact' => [
                'contact_hero_eyebrow' => 'Contact Us',
                'contact_hero_heading' => "Let's talk.",
                'contact_hero_subtext' => 'Questions about starting a chapter, media enquiries, partnership ideas, or just something on your mind — reach us directly, or send a message below.',
                'contact_intro_body' => "We're a small, youth-led team, so a real person reads every message — expect a reply within a few working days.",
            ],
            'what_we_do' => [
                'what_we_do_hero_eyebrow' => 'What We Do',
                'what_we_do_hero_heading' => 'Every programme, grouped by purpose.',
                'what_we_do_hero_subtext' => 'From think sessions to public demonstrations — each programme is built to meet young people where they are.',
            ],
            'privacy' => [
                'privacy_hero_eyebrow' => 'Privacy & Cookies',
                'privacy_hero_heading' => 'What we store, and why.',
                'privacy_hero_subtext' => "A plain-language account of what this site stores in your browser and why — nothing more than what's listed here.",
                'privacy_cookies_eyebrow' => 'Cookies we set',
                'privacy_cookies_heading' => 'Essential only.',
                'privacy_cookie_1_name' => 'Session cookie',
                'privacy_cookie_1_body' => 'Keeps you signed in to the admin panel and protects every form on this site (contact, newsletter, chat) against cross-site request forgery. The site cannot function without it.',
                'privacy_cookie_2_name' => 'locale',
                'privacy_cookie_2_body' => "Remembers the language you chose from the switcher, so you don't have to pick it again on your next visit. Expires after a year.",
                'privacy_cookie_3_name' => 'cookie_consent',
                'privacy_cookie_3_body' => "Remembers that you've dismissed the cookie notice, so it doesn't show again. Expires after a year.",
                'privacy_storage_eyebrow' => 'Stored in your browser',
                'privacy_storage_heading' => 'Not sent to us.',
                'privacy_storage_body' => 'Your light/dark mode preference is saved with localStorage rather than a cookie — it stays on your device and is never transmitted to our server.',
                'privacy_notrack_eyebrow' => "What we don't use",
                'privacy_notrack_heading' => 'No tracking.',
                'privacy_notrack_body' => 'No advertising cookies, no analytics trackers, and nothing that follows you to other websites. If that ever changes, this page — and the notice you saw — changes with it.',
            ],
            'articles_page' => [
                'articles_page_hero_eyebrow' => 'Articles',
                'articles_page_hero_heading' => 'Reporting, explainers and stories.',
                'articles_page_hero_subtext' => 'Fact-checked coverage of tobacco harm, industry tactics and policy — plus the campaigns, chapters and young people driving the response.',
            ],
            'events_page' => [
                'events_page_hero_eyebrow' => 'Events',
                'events_page_hero_heading' => 'Where to find us next.',
                'events_page_hero_subtext' => 'Think sessions, school visits, public demonstrations and Community Imbizos happening across the country — open to any young person, school or community group who wants to take part.',
            ],
            'gallery_page' => [
                'gallery_page_hero_eyebrow' => 'Gallery',
                'gallery_page_hero_heading' => 'SATFYF, in the field.',
                'gallery_page_hero_subtext' => 'Think sessions, school visits, public demonstrations and Community Imbizos — a running record of where young people are showing up and speaking out.',
            ],
            'resources_page' => [
                'resources_page_hero_eyebrow' => 'Resources',
                'resources_page_hero_heading' => 'Facts you can hand someone.',
                'resources_page_hero_subtext' => 'Fact sheets, toolkits and reports — free to download and share.',
            ],
            'partners' => [
                'partners_hero_eyebrow' => 'Partners & Collaborative',
                'partners_hero_heading' => "We don't do this alone.",
                'partners_hero_subtext' => 'Schools, health organisations, government departments and community groups who share the venues, the credibility and the reach it takes to put tobacco-free choices in front of more young people.',
            ],
        ];

        foreach ($settings as $group => $pairs) {
            foreach ($pairs as $key => $value) {
                SiteSetting::query()->firstOrCreate(
                    ['key' => $key],
                    ['group' => $group, 'value' => $value === '' ? null : json_encode(['en' => $value])],
                );
            }
        }

        // mission.org_motto: same dead-hook situation as youth_chapters/
        // champions_network above — gated behind being non-empty, left
        // empty so the quote block stays hidden until an admin fills it in.
        SiteSetting::query()->firstOrCreate(
            ['key' => 'org_motto'],
            ['group' => 'mission', 'value' => null],
        );

        // hero.hero_closing_subtext: the shared x-ui.closing-cta component
        // (Who We Are, What We Do) had its subtext hardcoded even though
        // its heading already reads from this same `hero` group.
        SiteSetting::query()->firstOrCreate(
            ['key' => 'hero_closing_subtext'],
            ['group' => 'hero', 'value' => json_encode(['en' => 'No membership fee. Open to every school and community.'])],
        );

        // trusted_by_heading is used on the Home page's partner marquee,
        // not the Partners page — move it out of `partners` so that group
        // belongs solely to the Partners page's own content.
        DB::table('site_settings')->where('key', 'trusted_by_heading')->update(['group' => 'trusted_by']);

        SiteSetting::forgetCache();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('site_settings')->where('key', 'trusted_by_heading')->update(['group' => 'partners']);

        SiteSetting::query()->whereIn('group', [
            'why_we_exist',
            'get_involved',
            'who_we_are',
            'youth_chapters',
            'champions_network',
            'what_we_do',
            'privacy',
            'articles_page',
            'events_page',
            'gallery_page',
            'resources_page',
        ])->delete();

        SiteSetting::query()->where('group', 'contact')->whereIn('key', [
            'contact_hero_eyebrow', 'contact_hero_heading', 'contact_hero_subtext', 'contact_intro_body',
        ])->delete();

        SiteSetting::query()->where('group', 'partners')->whereIn('key', [
            'partners_hero_eyebrow', 'partners_hero_heading', 'partners_hero_subtext',
        ])->delete();

        SiteSetting::query()->where('key', 'org_motto')->delete();
        SiteSetting::query()->where('key', 'hero_closing_subtext')->delete();

        SiteSetting::forgetCache();
    }
};
