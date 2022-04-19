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
            'title'                  => 'Example Band',
            'subtitle'               => 'with the fake opacity',
            'date'                   => Carbon::parse('+2 weeks'),
            'ticket_price'           => 2000,
            'venue'                  => 'The Example Theatre',
            'venue_address'          => '123 example Lane',
            'city'                   => 'Ismailia',
            'state'                  => 'Ismailia',
            'zip'                    => 90210,
            'additional_information' => 'For tickets, call (555) 555-5555.',
        ];
    }
}
