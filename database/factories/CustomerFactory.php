<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'contract_at' => $this->faker->dateTimeBetween('-1 year', '+1 year'),
            'active' => $this->faker->boolean,
            'user_id' => function () {
                return User::factory()->create()->id;
            },
        ];
    }
}
