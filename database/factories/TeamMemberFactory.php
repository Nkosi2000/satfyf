<?php

namespace Database\Factories;

use App\Models\TeamMember;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TeamMember>
 */
class TeamMemberFactory extends Factory
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
            'role' => fake()->randomElement([
                'Programme Coordinator', 'Youth Advocacy Lead', 'Community Liaison',
                'Communications Officer', 'Research & Policy Officer', 'Volunteer Manager',
            ]),
            'bio' => fake()->paragraph(3),
            'photo_path' => null,
            'order' => fake()->numberBetween(0, 20),
            'published' => true,
        ];
    }
}
