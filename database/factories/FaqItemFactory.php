<?php

namespace Database\Factories;

use App\Models\FaqItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FaqItem>
 */
class FaqItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'question' => fake()->sentence(8).'?',
            'answer' => fake()->paragraph(3),
            'order' => fake()->numberBetween(0, 20),
            'published' => true,
        ];
    }
}
