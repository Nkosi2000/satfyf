<?php

namespace Database\Factories;

use App\Models\Testimonial;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Testimonial>
 */
class TestimonialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'role' => fake()->randomElement(['Youth Ambassador', 'Parent', 'Teacher', 'Community Partner']),
            'quote' => fake()->paragraph(2),
            'photo_path' => null,
            'order' => fake()->numberBetween(0, 20),
            'published' => true,
        ];
    }
}
