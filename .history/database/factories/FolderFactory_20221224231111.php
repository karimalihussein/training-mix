<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Folder>
 */
class FolderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'parent_id' => null,
            'root_id' => null,
            'name' => $this->faker->unique()->name,
            'color' => $this->faker->colorName,
            'icon' => $this->faker->word,
            'type' => 'folder',
            'is_public' => false,
        ];
    }
}
