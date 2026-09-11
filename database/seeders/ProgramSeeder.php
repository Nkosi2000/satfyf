<?php

namespace Database\Seeders;

use App\Enums\ProgramCategory;
use App\Models\Program;
use Illuminate\Database\Seeder;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $programs = [
            ['title' => 'Think Sessions', 'category' => ProgramCategory::Education, 'description' => 'Structured youth dialogues that unpack the health, economic and social harms of tobacco in plain language.'],
            ['title' => 'Social Media Conversations', 'category' => ProgramCategory::Media, 'description' => 'Ongoing campaigns across Facebook, Instagram, Twitter and YouTube that put youth voices at the centre of the tobacco-free message.'],
            ['title' => 'Media Advocacy Events', 'category' => ProgramCategory::Media, 'description' => 'Press engagements and public messaging that hold industry and policymakers accountable.'],
            ['title' => 'Public Demonstrations', 'category' => ProgramCategory::Advocacy, 'description' => 'Visible, youth-led action that pushes for stronger tobacco control policy and enforcement.'],
            ['title' => 'Community Imbizos', 'category' => ProgramCategory::Community, 'description' => 'Traditional community gatherings that bring parents, schools and youth together around a shared smoke-free goal.'],
            ['title' => 'School Outreach', 'category' => ProgramCategory::Education, 'description' => 'On-the-ground sessions at schools building toward smoke-free educational institutions.'],
        ];

        foreach ($programs as $order => $program) {
            Program::query()->updateOrCreate(
                ['title' => $program['title']],
                [...$program, 'category' => $program['category']->value, 'order' => $order, 'published' => true],
            );
        }
    }
}
