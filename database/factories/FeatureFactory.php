<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Feature;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Feature>
 */
class FeatureFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => fake()->sentence(),
            'status' => fake()->randomElement([Feature::STATUS_REQUESTED, Feature::STATUS_APPROVED, Feature::STATUS_REJECTED, Feature::STATUS_DELETED]),
        ];
    }
}
