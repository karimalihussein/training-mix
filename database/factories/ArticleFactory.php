<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $title = fake()->sentence();

        return [
            'title' => $title,
            'slug' => Str::slug($title, '-'),
            'description' => fake()->paragraph(),
            'image' => fake()->imageUrl(),
            'user_id' => UserFactory::new()->create()->id,
            'published_at' => fake()->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
