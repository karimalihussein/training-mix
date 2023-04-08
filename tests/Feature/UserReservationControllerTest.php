<?php

namespace Tests\Feature;

use App\Models\Office;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UserReservationControllerTest extends TestCase
{
    
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
     $reservations =    Reservation::factory()->for($user)->createMany(
            [
                [
                    'start_date'   => '2022-03-01',
                    'end_date'     => '2022-03-15',
            ],
            [
                'start_date'   => '2022-03-15',
                'end_date'     => '2022-03-31',
            ],
       

   
            [
                'start_date'   => '2022-04-01',
                'end_date'     => '2022-04-05',
            ]
            ]

        );







        $this->actingAs($user);
        // DB::enableQueryLog();
        $response = $this->get('/api/reservations?'. http_build_query([
            'start_date' => $startDate,
            'end_date' => $endDate,
        ])); // ?start_date=2020-01-01&end_date=2020-01-31
        // dd(
        //     DB::getQueryLog()
        // );
        
        $response->assertJsonCount(3, 'data');

        $this->assertEquals($reservations->pluck('id')->toArray(), $response->json('data.*.id'));
        
       
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


    /**
     * test for store reservations
     * @test
     * @return void
     */
    public function test_store_reservation()
    {
        $user = User::factory()->create();
        $office = Office::factory()->create([
            'price_per_day'      => 1_000,
            'monthly_discount'   => 10,
        ]);

        $this->actingAs($user);

        $response = $this->post('/api/reservations', [
            'start_date'    =>   now()->addDays(1)->format('Y-m-d'),
            'end_date'      =>   now()->addDays(41)->format('Y-m-d'),
            'office_id'     => $office->id,
        ]);
        

        $response->assertCreated();

        $response->assertJsonPath('data.price', 36900)
        ->assertJsonPath('data.user_id', $user->id)
        ->assertJsonPath('data.office_id', $office->id)

        ->assertJsonPath('data.status',  Reservation::STATUS_ACTIVE);
        
    }
    
    /**
     * it cannot make reservations on non existing office
     * @test
     * @return void
     */
    public function test_cannot_make_reservation_on_non_existing_office()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->post('/api/reservations', [
            'start_date'    =>   now()->addDays(1)->format('Y-m-d'),
            'end_date'      =>   now()->addDays(41)->format('Y-m-d'),
            'office_id'     => 999,
        ]);

        $response->assertStatus(422);
    }

    /*
    * it cannot make reservation on office that belongs To User
    * @test
    * @return void
    */
    public function test_cannot_make_reservation_on_office_that_belongs_to_user()
    {
        $user = User::factory()->create();
        $office = Office::factory()->for($user)->create();

        $this->actingAs($user);

        $response = $this->post('/api/reservations', [
            'start_date'    =>   now()->addDays(1)->format('Y-m-d'),
            'end_date'      =>   now()->addDays(41)->format('Y-m-d'),
            'office_id'     => $office->id,
        ]);

        $response->assertStatus(422);
  
    }

    /**
     * it cannot make reservation thats conflicting
     * @test
     * @return void
     */
    // public function test_cannot_make_reservation_that_conflicting()
    // {
    //     $user = User::factory()->create();
    //     $office = Office::factory()->create();
    //     $this->actingAs($user);

    //     $reservation = Reservation::factory()->for($user)->for($office)->create([
    //         'start_date'    =>   now()->addDays(1)->format('Y-m-d'),
    //         'end_date'      =>   now()->addDays(41)->format('Y-m-d'),
    //     ]);

    //     // dd($reservation);
 

    //     // $response->assertStatus(302);

    //     // dd($response->dd());
    // }
}
