<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Concert>
 */
class ConcertFactory extends Factory
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
            'subtitle' => fake()->sentence(),
            'date' => fake()->dateTimeBetween('-1 month', '+1 month'),
            'ticket_price' => fake()->numberBetween(100, 1000000),
            'venue' => fake()->streetName(),
            'venue_address' => fake()->streetAddress(),
            'city' => fake()->city(),
            'state' => fake()->state(),
            'zip' => fake()->postcode(),
            'published_at' => fake()->dateTimeBetween('-1 month', '+1 month'),
            'additional_information' => 'For tickets, call (555) 555-5555.',
        ];
    }
}
