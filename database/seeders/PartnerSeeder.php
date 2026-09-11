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
            ['name' => 'National Council Against Smoking', 'type' => PartnerType::Partner],
            ['name' => 'Department of Health', 'type' => PartnerType::Collaborator],
            ['name' => 'Cancer Association of South Africa', 'type' => PartnerType::Partner],
            ['name' => 'South African Medical Research Council', 'type' => PartnerType::Collaborator],
        ];

        foreach ($partners as $order => $partner) {
            Partner::query()->updateOrCreate(
                ['name' => $partner['name']],
                [...$partner, 'type' => $partner['type']->value, 'order' => $order, 'published' => true],
            );
        }
    }
}
