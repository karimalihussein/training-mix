<?php

namespace Tests\Unit;

use App\Models\Concert;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

class ConcertTest extends TestCase
{
 

    /** @test */
    public function cat_get_formated_start_time()
    {

         $concert = Concert::create([
            'title'      => 'The Red Chord',
            'date'       => Carbon::parse('2017-12-31 17:00:00'),
            'ticket_price' => 3250,
            'venue' => 'The Mosh Pit',
            'venue_address' => '123 Example Lane',
            'city' => 'Laraville',
            'state' => 'ON',
            'zip' => '17916',
            'additional_information' => 'For tickets, call (555) 555-5555.',
         ]);

         $this->assertEquals('The Red Chord', $concert->title);
         
    }
}
