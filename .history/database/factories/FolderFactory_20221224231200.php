<?php

namespace Database\Factories;

use App\Models\User;
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
            'user_id' => User::factory(),
            'parent_id' => null,
            'root_id' => null,
            'name' => fake()->unique()->name,
            'color' => fake()->colorName,
            'icon' => fake()->word,
            'type' => 'folder',
            'is_public' => false,
        ];
    }
}
