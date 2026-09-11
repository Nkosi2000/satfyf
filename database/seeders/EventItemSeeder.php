<?php

namespace Database\Seeders;

use App\Models\EventItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EventItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = [
            [
                'title' => 'Centurion Youth Think Session',
                'description' => "A facilitated Think Session for learners on the real health and economic costs of tobacco.\n\nOpen to grades 10-12, no registration fee.",
                'location' => 'Corporate Park 66, Centurion',
                'starts_at' => now()->addWeeks(2)->setTime(14, 0),
                'is_featured' => true,
            ],
            [
                'title' => 'World No Tobacco Day Demonstration',
                'description' => "A public demonstration marking World No Tobacco Day, led entirely by SATFYF youth ambassadors.",
                'location' => 'Church Square, Pretoria',
                'starts_at' => now()->addMonths(1)->setTime(9, 0),
                'is_featured' => true,
            ],
            [
                'title' => 'Community Imbizo: Soshanguve',
                'description' => "A community gathering bringing parents, teachers and youth together to talk openly about tobacco and substance abuse in the community.",
                'location' => 'Soshanguve Community Hall',
                'starts_at' => now()->addWeeks(6)->setTime(10, 0),
            ],
            [
                'title' => 'Media Advocacy Breakfast',
                'description' => "SATFYF briefs local media on youth tobacco trends ahead of policy review season.",
                'location' => 'Centurion',
                'starts_at' => now()->subMonths(1)->setTime(8, 0),
            ],
            [
                'title' => 'Youth Ambassador Training Camp',
                'description' => "A weekend training camp equipping new volunteers to run Think Sessions in their own schools.",
                'location' => 'Hartbeespoort',
                'starts_at' => now()->subWeeks(3)->setTime(9, 0),
            ],
        ];

        foreach ($events as $event) {
            EventItem::query()->updateOrCreate(
                ['slug' => Str::slug($event['title'])],
                [
                    ...$event,
                    'slug' => Str::slug($event['title']),
                    'ends_at' => $event['starts_at']->clone()->addHours(3),
                    'cover_image_path' => null,
                    'published' => true,
                ],
            );
        }

        EventItem::factory(4)->create();
    }
}
