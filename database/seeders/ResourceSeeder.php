<?php

namespace Database\Seeders;

use App\Models\Resource;
use Illuminate\Database\Seeder;

class ResourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $resources = [
            ['title' => 'Youth Tobacco Facts Sheet 2026', 'category' => 'Fact Sheet', 'description' => 'Key statistics on youth tobacco and nicotine use in South Africa.'],
            ['title' => 'Vision 2030 Strategy Brief', 'category' => 'Policy Brief', 'description' => 'SATFYF\'s full strategy toward a smoke-free generation by 2030.'],
            ['title' => 'Think Session Facilitator Toolkit', 'category' => 'Toolkit', 'description' => 'Everything a volunteer needs to run a Think Session at their own school.'],
            ['title' => 'Annual Impact Report', 'category' => 'Report', 'description' => 'A look back at SATFYF\'s programmes, reach and outcomes over the past year.'],
        ];

        foreach ($resources as $resource) {
            Resource::query()->updateOrCreate(
                ['title' => $resource['title']],
                [...$resource, 'file_path' => 'resources/placeholder.pdf', 'published' => true],
            );
        }
    }
}
