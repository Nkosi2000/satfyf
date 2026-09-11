<?php

namespace Database\Seeders;

use App\Models\FaqItem;
use Illuminate\Database\Seeder;

class FaqItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqs = [
            ['question' => 'What does SATFYF actually do?', 'answer' => 'We run youth-led think sessions, media campaigns, public demonstrations and community imbizos that push back against tobacco, nicotine, substance and drug abuse among young South Africans.'],
            ['question' => 'Who can get involved?', 'answer' => 'Any young person, school, parent or organisation that wants a smoke-free generation. Volunteers, schools and community groups are all welcome.'],
            ['question' => 'Is SATFYF affiliated with government?', 'answer' => 'We are an independent youth forum that collaborates with government departments, health bodies and civil society partners on tobacco control.'],
            ['question' => 'How is SATFYF funded?', 'answer' => 'Through partnerships, grants and donor support. See our Partners & Collaborative page for current partners.'],
            ['question' => 'Where are you based?', 'answer' => 'Our office is in Centurion, Pretoria, but our programmes run across South Africa through local chapters and community imbizos.'],
        ];

        foreach ($faqs as $order => $faq) {
            FaqItem::query()->updateOrCreate(
                ['question' => $faq['question']],
                [...$faq, 'order' => $order, 'published' => true],
            );
        }
    }
}
