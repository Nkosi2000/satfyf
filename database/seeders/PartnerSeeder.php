<?php

namespace Database\Seeders;

use App\Enums\PartnerType;
use App\Models\Partner;
use Illuminate\Database\Seeder;

class PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $partners = [
            [
                'name' => 'National Council Against Smoking',
                'type' => PartnerType::Partner,
                'role' => 'Provides national policy expertise and campaign backing',
                'description' => 'A long-standing tobacco-control advocacy body that helped shape the Think Session curriculum and reviews our public messaging for accuracy.',
            ],
            [
                'name' => 'Department of Health',
                'type' => PartnerType::Collaborator,
                'role' => 'Opens school and clinic access for youth programmes',
                'description' => 'Coordinates with provincial health offices so Think Sessions and Community Imbizos can run inside schools and clinics across the country.',
            ],
            [
                'name' => 'Cancer Association of South Africa',
                'type' => PartnerType::Partner,
                'role' => 'Supplies health-impact research and educational material',
                'description' => 'Shares up-to-date research on tobacco-related illness that grounds our education material in real evidence, not scare tactics.',
            ],
            [
                'name' => 'South African Medical Research Council',
                'type' => PartnerType::Collaborator,
                'role' => 'Evaluates programme outcomes and youth health data',
                'description' => 'Independently evaluates our programmes and contributes youth tobacco-use data that shapes where we focus next.',
            ],
        ];

        foreach ($partners as $order => $partner) {
            Partner::query()->updateOrCreate(
                ['name' => $partner['name']],
                [...$partner, 'type' => $partner['type']->value, 'order' => $order, 'published' => true],
            );
        }
    }
}
