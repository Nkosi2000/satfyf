<?php

namespace Database\Factories;

use App\Models\GalleryImage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<GalleryImage>
 */
class GalleryImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'caption' => fake()->sentence(4),
            'image_path' => 'https://picsum.photos/seed/'.fake()->unique()->numberBetween(1, 100000).'/800/600',
            'category' => fake()->randomElement(['Campaigns', 'Community Imbizos', 'Think Sessions', 'Demonstrations']),
            'order' => fake()->numberBetween(0, 40),
        ];
    }
}
