<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $testimonials = [
            [
                'name' => 'Thabo Mahlangu',
                'role' => 'Youth Ambassador, Centurion',
                'quote' => 'Before SATFYF, I thought vaping was just something everyone did. Running my own Think Session changed how my whole friend group talks about it.',
            ],
            [
                'name' => 'Nomvula Dlamini',
                'role' => 'Parent',
                'quote' => "My son came home from a Community Imbizo and started a conversation with our whole family about smoking that we'd never had before. That's the kind of thing that actually changes a household.",
            ],
            [
                'name' => 'Mr. Sithole',
                'role' => 'Life Orientation Teacher',
                'quote' => "The facilitators don't lecture — they let the learners argue it out themselves. It's the first tobacco-education programme I've seen that learners actually ask to have back.",
            ],
            [
                'name' => 'Karabo Mokoena',
                'role' => 'Youth Ambassador, Soshanguve',
                'quote' => "No membership fee, no gatekeeping — I just showed up to a Think Session and a year later I'm leading them at my own school.",
            ],
        ];

        foreach ($testimonials as $order => $testimonial) {
            Testimonial::query()->updateOrCreate(
                ['quote->en' => $testimonial['quote']],
                [...$testimonial, 'order' => $order, 'published' => true],
            );
        }
    }
}
