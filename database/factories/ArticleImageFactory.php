<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\ArticleImage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ArticleImage>
 */
class ArticleImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'article_id' => Article::factory(),
            'image_path' => 'https://picsum.photos/seed/'.fake()->unique()->numberBetween(1, 100000).'/600/600',
            'order' => fake()->numberBetween(0, 20),
        ];
    }
}
