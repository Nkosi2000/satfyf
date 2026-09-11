<?php

namespace Database\Factories;

use App\Models\Resource;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Resource>
 */
class ResourceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(4),
            'description' => fake()->paragraph(2),
            'file_path' => 'resources/placeholder.pdf',
            'category' => fake()->randomElement(['Fact Sheet', 'Report', 'Toolkit', 'Policy Brief']),
            'published' => true,
        ];
    }
}
