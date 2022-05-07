<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Concert;

class ViewConcertListingTest extends TestCase
{
   
    /** @test */
    function user_can_view_concert_listing()
    {
        $this->withoutExceptionHandling();

        $concert = Concert::create([
            'title' => 'The Red Chord',
            'subtitle' => 'with Animosity and Lethargy',
            'date' => Carbon::parse('December 13, 2019 8:00pm'),
            'ticket_price' => 3250,
            'venue' => 'The Mosh Pit',
            'venue_address' => '123 Example Lane',
            'city' => 'Laraville',
            'state' => 'ON',
            'zip' => '17916',
            'additional_information' => 'For tickets, call (555) 555-5555.',
            'published_at' => Carbon::parse('now')
        ]);

        $response = $this->get('/concerts/'.$concert->id);

        $response->assertStatus(200);

        $response->assertSee('The Red Chord');
        $response->assertSee('with Animosity and Lethargy');
        $response->assertSee('The Mosh Pit');
        $response->assertSee('123 Example Lane');
        $response->assertSee('Laraville, ON 17916');
        $response->assertSee('For tickets, call (555) 555-5555.');

        $concert->delete();

    }


    /** @test */
    function user_cannot_view_unpublished_concert_listing()
    {
        $concert = Concert::factory()->create([
                   'published_at' => null
        ]);

        $response = $this->get('/concerts/'.$concert->id);

        $response->assertStatus(404);

        $concert->delete();

       

    }

    
}
