<?php

namespace Database\Factories;

use Carbon\Carbon;
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
            'title'                  =>  $this->faker->sentence(),
            'subtitle'               =>  $this->faker->sentence(),
            'date'                   =>  $this->faker->dateTimeBetween('-1 month', '+1 month'),
            'ticket_price'           =>  $this->faker->numberBetween(100, 1000000),
            'venue'                  =>  $this->faker->streetName(),
            'venue_address'          =>  $this->faker->streetAddress(),
            'city'                   =>  $this->faker->city(),
            'state'                  =>  $this->faker->state(),
            'zip'                    =>  $this->faker->postcode(),
            'published_at'           =>  $this->faker->dateTimeBetween('-1 month', '+1 month'),
            'additional_information' => 'For tickets, call (555) 555-5555.',
        ];
    }
}
