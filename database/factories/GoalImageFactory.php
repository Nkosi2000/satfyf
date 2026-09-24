<?php

namespace Database\Factories;

use App\Models\GoalImage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<GoalImage>
 */
class GoalImageFactory extends Factory
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
            'image_path' => 'https://picsum.photos/seed/'.fake()->unique()->numberBetween(1, 100000).'/800/1000',
            'order' => fake()->numberBetween(0, 10),
        ];
    }
}
