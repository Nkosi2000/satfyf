<?php

namespace Database\Factories;

use App\Models\EventItem;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<EventItem>
 */
class EventItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence(4);
        $startsAt = fake()->dateTimeBetween('-2 months', '+3 months');

        return [
            'title' => $title,
            'slug' => Str::slug($title).'-'.fake()->unique()->numberBetween(1, 100000),
            'description' => implode("\n\n", fake()->paragraphs(3)),
            'location' => fake()->city().', South Africa',
            'starts_at' => $startsAt,
            'ends_at' => (clone $startsAt)->modify('+3 hours'),
            'cover_image_path' => null,
            'is_featured' => false,
            'published' => true,
        ];
    }

    public function featured(): static
    {
        return $this->state(fn () => ['is_featured' => true]);
    }
}
