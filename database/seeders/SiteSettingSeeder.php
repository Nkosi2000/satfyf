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
                'vision_2030_1_icon' => 'users',
                'vision_2030_2' => 'Every educational institution is smoke-free.',
                'vision_2030_2_icon' => 'book',
                'vision_2030_3' => 'Youth confidently decline every tobacco offer.',
                'vision_2030_3_icon' => 'shield',
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
            'partners' => [
                'trusted_by_heading' => 'Trusted by',
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
                $locales = is_array($value) ? $value : ['en' => $value];

                SiteSetting::query()->updateOrCreate(
                    ['key' => $key],
                    ['group' => $group, 'value' => json_encode($locales)],
                );
            }
        }
    }
}
