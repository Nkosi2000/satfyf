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
                'hero_closing_subtext' => 'No membership fee. Open to every school and community.',
            ],
            'overview' => [
                'overview' => 'Youth voices championing & fighting against the harsh and dangerous realities of tobacco, as well as substance & drug abuse amongst young people.',
            ],
            'mission' => [
                'mission_tagline' => 'We speak and spread the truth about smoking.',
                'org_motto' => '',
                'vision_2030_1' => 'Young people reject smoking in social settings.',
                'vision_2030_1_icon' => 'users',
                'vision_2030_2' => 'Every educational institution is smoke-free.',
                'vision_2030_2_icon' => 'book',
                'vision_2030_3' => 'Youth confidently decline every tobacco offer.',
                'vision_2030_3_icon' => 'shield',
            ],
            'contact' => [
                'contact_hero_eyebrow' => 'Contact Us',
                'contact_hero_heading' => "Let's talk.",
                'contact_hero_subtext' => 'Questions about starting a chapter, media enquiries, partnership ideas, or just something on your mind — reach us directly, or send a message below.',
                'contact_intro_body' => "We're a small, youth-led team, so a real person reads every message — expect a reply within a few working days.",
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
            'trusted_by' => [
                'trusted_by_heading' => 'Trusted by',
            ],
            'partners' => [
                'partners_hero_eyebrow' => 'Partners & Collaborative',
                'partners_hero_heading' => "We don't do this alone.",
                'partners_hero_subtext' => 'Schools, health organisations, government departments and community groups who share the venues, the credibility and the reach it takes to put tobacco-free choices in front of more young people.',
            ],
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
                'who_we_are_hero_subtext' => 'Youth voices championing & fighting against the harsh and dangerous realities of tobacco, as well as substance & drug abuse amongst young people.',
                'who_we_are_goals_heading' => 'SATFYF Goals & Objectives',
                'who_we_are_goals_intro' => 'Our main goal is to EDUCATE, INFORM and INFLUENCE CHANGE through:',
                'who_we_are_goal_1' => 'Creating A Formidable Youth Tobacco-Control Movement In South Africa',
                'who_we_are_goal_2' => 'Educating & Informing Young People About The Harsh Realities And The Effects Of Tobacco Through Various Digital And Physical Campaigns.',
                'who_we_are_goal_3' => 'Gaining Support & Putting Pressure On The Government To Process The Tobacco-Control Bill Through Various Legislative Stages.',
                'who_we_are_goal_4' => 'Disengaging The Tobacco Industry Through Persuasive Communications & Media Outreach Activities.',
                'who_we_are_vision_eyebrow' => 'Vision 2030',
                'who_we_are_vision_heading' => 'By 2030, we want to see.',
                'who_we_are_team_eyebrow' => 'The Team',
                'who_we_are_team_heading' => 'People behind the forum.',
                'who_we_are_team_body' => 'A small, youth-led core team coordinates chapters and campaigns across the country, backed by volunteers, mentors and partner organisations who help run every Think Session, Imbizo and demonstration on the ground.',
            ],
            // Left empty on purpose — see the matching migration note.
            'youth_chapters' => [
                'youth_chapters_eyebrow' => '',
                'youth_chapters_heading' => '',
                'youth_chapters_intro' => '',
                'youth_chapters_province_1' => '',
                'youth_chapters_province_2' => '',
                'youth_chapters_province_3' => '',
                'youth_chapters_province_4' => '',
            ],
            'champions_network' => [
                'champions_network_heading' => '',
                'champions_network_body' => '',
                'champions_network_cta_label' => '',
                'champions_network_cta_url' => '',
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
            'closing_cta' => [
                'closing_cta_heading' => 'Ready to speak up?',
                'closing_cta_body' => 'There is no membership fee, and no single way in. Start a Think Session, become a Youth Ambassador, or just tell us what you\'d like to do.',
            ],
            'why_it_matters' => [
                'why_it_matters_eyebrow' => [
                    'en' => 'Why It Matters',
                    'zu' => 'Kungani Kubalulekile',
                    'af' => 'Waarom Dit Saak Maak',
                    'st' => 'Hobaneng ho Bohlokwa',
                ],
                'why_it_matters_heading' => [
                    'en' => 'More than awareness.',
                    'zu' => 'Okungaphezu kokuqwashisa.',
                    'af' => 'Meer as net bewustheid.',
                    'st' => 'Ho feta tlhokomeliso feela.',
                ],
                'why_it_matters_tab_1' => [
                    'en' => 'Youth-led',
                    'zu' => 'Eholwa Yintsha',
                    'af' => 'Jeuggelei',
                    'st' => 'E etelletsweng pele ke bacha',
                ],
                'why_it_matters_tab_1_body' => [
                    'en' => 'Every campaign, think session and demonstration is planned and led by young people themselves, not adults speaking on their behalf.',
                    'zu' => 'Wonke umkhankaso, iseshini yokucabanga kanye nomashi kuhlelwa futhi kuholwa yintsha uqobo — hhayi abadala abakhuluma egameni layo.',
                    'af' => 'Elke veldtog, denksessie en betoging word deur jong mense self beplan en gelei — nie deur volwassenes wat namens hulle praat nie.',
                    'st' => 'Leeto le leng le le leng, potjhiso ya menahano le pontsho di rerwa le ho etellwa pele ke bacha ka bobona — eseng baholo ba buang bakeng sa bona.',
                ],
                'why_it_matters_tab_2' => [
                    'en' => 'Evidence-based',
                    'zu' => 'Okusekelwe Kobufakazi',
                    'af' => 'Bewysgebaseer',
                    'st' => 'E theilweng hodima bopaki',
                ],
                'why_it_matters_tab_2_body' => [
                    'en' => 'Our messaging is grounded in real research on tobacco harm, nicotine addiction and youth marketing tactics, not scare tactics.',
                    'zu' => 'Umlayezo wethu usekelwe ocwaningweni lwangempela ngengozi kagwayi, ukulutha kwe-nicotine kanye namasu okukhangisa entsheni — hhayi amasu okwesabisa.',
                    'af' => 'Ons boodskap is gegrond op werklike navorsing oor tabakskade, nikotienverslawing en jeugbemarkingstaktieke — nie skrikmaaktaktieke nie.',
                    'st' => 'Molaetsa wa rona o theilwe dipatlisisong tsa nnete mabapi le kotsi ya tobacco, boitlami ba nicotine le maano a papatso ho bacha — eseng maano a ho tshosa.',
                ],
                'why_it_matters_tab_3' => [
                    'en' => 'Community-rooted',
                    'zu' => 'Egxile emphakathini',
                    'af' => 'Gemeenskapsgewortel',
                    'st' => 'E metseng setjhabeng',
                ],
                'why_it_matters_tab_3_body' => [
                    'en' => 'Community Imbizos bring parents, teachers and local leaders into the conversation, because tobacco-free choices are made together.',
                    'zu' => 'Ama-Imbizo omphakathi aletha abazali, othisha kanye nabaholi bendawo engxoxweni, ngoba izinqumo zokungabhemi zenziwa ndawonye.',
                    'af' => 'Gemeenskap-Imbizos bring ouers, onderwysers en plaaslike leiers by die gesprek, want rookvrye keuses word saam gemaak.',
                    'st' => 'Diimbizo tsa setjhaba di kenya batswadi, matitjhere le baeta-pele ba lehae puisanong, hobane diqeto tse se nang tobacco di etswa mmoho.',
                ],
                'why_it_matters_tab_4' => [
                    'en' => 'Free to join',
                    'zu' => 'Mahhala ukujoyina',
                    'af' => 'Gratis om aan te sluit',
                    'st' => 'Ho kena ha ho lefe',
                ],
                'why_it_matters_tab_4_body' => [
                    'en' => 'There is no membership fee. Any young person, school or community group can join a Think Session or start a chapter.',
                    'zu' => 'Ayikho imali yobulungu. Noma imuphi umuntu osemusha, isikole noma iqembu lomphakathi lingajoyina Iseshini Yokucabanga noma liqale isigaba.',
                    'af' => 'Daar is geen lidmaatskapfooi nie. Enige jong persoon, skool of gemeenskapsgroep kan by \'n Denksessie aansluit of \'n tak begin.',
                    'st' => 'Ha ho tefo ya boitokiso. Motho ofe kapa ofe e motjha, sekolo kapa sehlopha sa setjhaba se ka kena Potjhisong ya Menahano kapa sa qala lekala.',
                ],
            ],
        ];

        foreach ($settings as $group => $pairs) {
            foreach ($pairs as $key => $value) {
                if ($value === '') {
                    $encoded = null;
                } else {
                    $encoded = json_encode(is_array($value) ? $value : ['en' => $value]);
                }

                SiteSetting::query()->updateOrCreate(
                    ['key' => $key],
                    ['group' => $group, 'value' => $encoded],
                );
            }
        }
    }
}
