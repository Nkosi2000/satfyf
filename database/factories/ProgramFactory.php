<?php

namespace Database\Factories;

use App\Enums\ProgramCategory;
use App\Models\Program;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Program>
 */
class ProgramFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'category' => fake()->randomElement(ProgramCategory::cases())->value,
            'description' => fake()->paragraph(2),
            'order' => fake()->numberBetween(0, 20),
            'published' => true,
        ];
    }
}
