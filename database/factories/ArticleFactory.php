<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence(6);

        return [
            'title' => $title,
            'slug' => Str::slug($title).'-'.fake()->unique()->numberBetween(1, 100000),
            'excerpt' => fake()->sentence(18),
            'body' => implode("\n\n", fake()->paragraphs(5)),
            'cover_image_path' => null,
            'author_name' => fake()->name(),
            'published_at' => fake()->dateTimeBetween('-6 months', 'now'),
        ];
    }

    public function draft(): static
    {
        return $this->state(fn () => ['published_at' => null]);
    }
}
