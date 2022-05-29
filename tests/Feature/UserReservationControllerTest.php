<?php

namespace Tests\Feature;

use App\Models\Office;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UserReservationControllerTest extends TestCase
{
    use LazilyRefreshDatabase;
   /**
    * get user reservations data 
    * @test
    * @return void
    */
    public function test_lists_reservations_that_belongs_to_the_user()
    {
        $user = User::factory()->create();
        $reservation = Reservation::factory()->for($user)->create();

        $image = $reservation->office->images()->create([
                'path'  => "image.jpg",
        ]);
        $reservation->office()->update(['featured_image_id' => $image->id]);
        Reservation::factory(10)->create();
        Reservation::factory(10)->for($user)->create();

        $this->actingAs($user);

        $response = $this->get('/api/reservations');

        $response
        ->assertJsonStructure(['data', 'meta', 'links'])
        ->assertJsonCount(11, 'data')
        ->assertJsonStructure(['data' => ['*' => ['id', 'office']]])
        // ->assertJsonPath('data.*.id', [$reservation->id])
        // ->assertJsonPath('data.*.office', [$reservation->office]);
        ->assertJsonPath('data.0.office.featured_image_id', $image->id);
    }

    /**
     * list reservations that fillterd by date range
     * @test
     * @return void
     */
    public function test_lists_reservations_that_filtered_by_date_range()
    {

        $user = User::factory()->create();
        $startDate = '2022-03-03';
        $endDate = '2022-04-04';
        // within the date range
     $reservation1 =    Reservation::factory()->for($user)->create([
            'start_date' => '2022-03-01',
            'end_date' => '2022-03-15',
        ]);

      $reservation2 =  Reservation::factory()->for($user)->create([
            'start_date' => '2022-03-16',
            'end_date' => '2022-03-31',
        ]);

        // out side the date range
        Reservation::factory()->for($user)->create([
            'start_date' => '2022-04-15',
            'end_date' => '2022-05-01',
        ]);

        Reservation::factory()->create([
            'start_date' => '2022-04-01',
            'end_date' => '2022-04-02',
        ]);



        $this->actingAs($user);
        // DB::enableQueryLog();
        $response = $this->get('/api/reservations?'. http_build_query([
            'start_date' => $startDate,
            'end_date' => $endDate,
        ])); // ?start_date=2020-01-01&end_date=2020-01-31
        // dd(
        //     DB::getQueryLog()
        // );
        
        $response->assertJsonCount(2, 'data')
        ->assertJsonPath('data.0.id', $reservation1->id)
        ->assertJsonPath('data.1.id', $reservation2->id);
       
    }

    /**
     * it fillter reservations by status 
     * @test
     * @return void
     */
    public function test_lists_reservations_that_filtered_by_status()
    {
            $user = User::factory()->create();

            $reservation1 = Reservation::factory()->for($user)->create([
                'status' => Reservation::STATUS_ACTIVE
            ]);

            $reservation2 = Reservation::factory()->cancelled()->for($user)->create();

            $this->actingAs($user);

            $response = $this->get('/api/reservations?'. http_build_query([
                'status' => Reservation::STATUS_ACTIVE
            ]));

            $response->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.id', $reservation1->id);

    }

    /**
     * if fillter reservations by office
     * @test
     * @return void
     */
    public function test_lists_reservations_that_filtered_by_office()
    {
        $user = User::factory()->create();
        $office = Office::factory()->create();
        $reservation1 = Reservation::factory()->for($user)->for($office)->create();

        $reservation2 = Reservation::factory()->for($user)->create();

        $this->actingAs($user);

        $response = $this->get('/api/reservations?'. http_build_query([
            'office_id' => $office->id
        ]));

        $response->assertJsonCount(1, 'data')
        ->assertJsonPath('data.0.id', $reservation1->id);

    }
}
