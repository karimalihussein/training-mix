<?php

namespace Tests\Feature;

use App\Models\Image;
use App\Models\Office;
use App\Models\Reservation;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OfficeControllerTest extends TestCase
{
    // use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_office_paginate_list()
    {
        Office::factory(10)->create();
        $response = $this->get('/api/offices');
       

        $response->assertStatus(200);

        $this->assertCount(10, $response->json('data'));
        // $this->assertNotNull($response->json('data')[0]['id']);
        // $this->assertNotNull($response->json('meta'));
        // $this->assertNotNull($response->json('links'));
       
    }


    /**
     * test only offices that not hidden and approved
     * @test
     * @return void
     */
    public function test_office_paginate_list_only_approved_and_not_hidden()
    {
        Office::factory(3)->create();
        $response = $this->get('/api/offices');

        Office::factory()->create(['hidden' => true]);
        Office::factory()->create(['approval_status' => Office::APPROVAL_PENDING]);

        $response->assertStatus(200);
        $response->assertOk();

 
    }


    /**
     * test filter by host_id 
     * @test
     * @return void
     */
    public function test_office_filter_by_host_id()
    {
        /* old way use for relationship between factories */
                // $host = User::factory()->create();
                // $office = Office::factory()->create(['user_id' => $host->id]);

        /* new way use for relationship between factories */
        $host = User::factory()->create();
        $office = Office::factory()->for($host)->create();
        $response = $this->get('/api/offices?user_id='.$host->id);
        $response->assertStatus(200);
        $response->assertOk();
        $response->assertJsonCount(1, 'data');
        $response->assertJsonFragment([
            'id' => $office->id,
        ]);
    }


    /**
     * test filter by user id with relationship reservations
     * @test
     * @return void
     */
    public function test_office_filter_by_user_id_with_relationship_reservations()
    {
        $user = User::factory()->create();
        $office = Office::factory()->for($user)->create();
        Reservation::factory()->for($user)->for($office)->create();
        Reservation::factory()->for(Office::factory()->create());
     
        $response = $this->get('/api/offices?visitor_id='.$user->id);
        $response->assertStatus(200);
        $response->assertOk();
        $response->assertJsonCount(1, 'data');
        $response->assertJsonFragment([
            'id' => $office->id,
        ]);
    }


    /*
    * test including images and tags and user relationships
    * @test
    * @return void
    */
    public function test_office_include_images_and_tags_and_user_relationships()
    {
        $user = User::factory()->create();

        $office = Office::factory()->for($user)->create();

        $tag = Tag::factory()->create();


        $office->tags()->attach($tag);
        $office->images()->create(['path' => 'image.jpg']);

     



        $response = $this->get('/api/offices');
        $response->assertStatus(200);
        $response->assertOk();

        $this->assertIsArray($response->json('data')[0]['tags']);
        $this->assertIsArray($response->json('data')[0]['images']);
        $this->assertIsArray($response->json('data')[0]['user']);

        $this->assertEquals($user->id, $response->json('data')[0]['user']['id']);
        $this->assertEquals($tag->id, $response->json('data')[0]['tags'][0]['id']);
        $this->assertEquals('image.jpg', $response->json('data')[0]['images'][0]['path']);
        


     




 
    }


    /**
     * return the nubmers of the active reservations
     * @test
     * @return void
     */
    public function test_office_return_the_nubmers_of_the_active_reservations()
    {
        $user = User::factory()->create();
        $office = Office::factory()->for($user)->create();
        Reservation::factory()->for($user)->for($office)->create(['status' => Reservation::STATUS_ACTIVE]);
        Reservation::factory()->for($user)->for($office)->create(['status' => Reservation::STATUS_CANCELLED]);
        $response = $this->get('/api/offices');
        $response->assertStatus(200);
        $response->assertOk();
        $response->assertJsonFragment([
            'id' => $office->id,
            'reservations_count' => 1
        ]);

  
    }


    /**
     * test method for testing latitude and longitude coordinates near the center of the office
     * @test
     * @return void
     */
     
     public function test_latitude_longitude_coordinates_near_the_center_of_the_office()
     {
         // 30.59258882022191, 32.27597631110485  | El Sultan Hussein State
       

        $office1 = Office::factory()->create([
                    'lat'     => '30.592976709029088', 
                    'lng'     => '32.27420605322389', 
                    'title'   => 'Misr Islamic Bank'
        ]);

        $office2 = Office::factory()->create([
            'lat'     => '30.5950731288052', 
            'lng'     => '32.27259672787757', 
            'title'   => 'Safeya Zagloul Preparatory School for Girls'
        ]);

        $office3 = Office::factory()->create([
            'lat'     => '30.596689280534406', 
            'lng'     => '32.27147020006751', 
            'title'   => 'Tolip Alforsan Island Hotel And Spa'
        ]);

        $office3 = Office::factory()->create([
                    'lat'       => '30.609421865254006',
                    'lng'       => '32.2635132585508',
                    'title'     => 'Medical centre El Salam'
        ]);

        $office4 = Office::factory()->create([
                'lat'           => '30.61408968424824',
                'lng'           => '32.271722068776675',
                'title'         => 'Baraka Restaurant for local food'
        ]);
        

        $response = $this->get('/api/offices?lat=30.59258882022191&lng=32.27597631110485');
        
        $response->assertStatus(200);
        $response->assertOk();
        // $response->dump();
        $this->assertEquals('Misr Islamic Bank', $response->json('data')[0]['title']);
        $this->assertEquals('Safeya Zagloul Preparatory School for Girls', $response->json('data')[1]['title']);
        $this->assertEquals('Tolip Alforsan Island Hotel And Spa', $response->json('data')[2]['title']);
        $this->assertEquals('Medical centre El Salam', $response->json('data')[3]['title']);
        $this->assertEquals('Baraka Restaurant for local food', $response->json('data')[4]['title']);

     
     }

     /**
      * test for show single office 
      * @test
      * @return void
      */
      public function test_show_single_office()
      {
          $office = Office::factory()->create();
          $response = $this->get('/api/offices/'.$office->id);
          $response->assertStatus(200);
          $response->assertOk();
          $response->assertJsonFragment([
                'id' => $office->id,
          ]);
      }

      /**
       * test for create new office
       * @test
       * @return void
       */
         public function test_create_new_office()
         {
              $user = User::factory()->create();

              $this->actingAs($user);

              $response =      $this->postJson('/api/offices', [
                            'title'     => 'test office',
            ]);
            dd($response);
         
         }
      
     




}
