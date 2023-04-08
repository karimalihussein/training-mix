<?php

namespace Tests\Feature;

use App\Models\Image;
use App\Models\Office;
use App\Models\Reservation;
use App\Models\Tag;
use App\Models\User;
use App\Notifications\OfficePendingApproval;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Notification;
use Illuminate\Http\UploadedFile;


class OfficeControllerTest extends TestCase
{
    
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
              $user = User::factory()->create(['is_admin' => true]);

              Notification::fake();

              $tag = Tag::factory()->create();
              $tag2 = Tag::factory()->create();

              Sanctum::actingAs($user, ['*']);
              

              $response =      $this->postJson('/api/offices', [
                            'title'             => 'test office',
                            'description'       => 'test description',
                            'lat'               => '30.59258882022191',
                            'lng'               => '32.27597631110485',
                            'address_line1'     => 'test address',
                            'price_per_day'     => 10_000,
                            'monthly_discount'  => 5,
                            'tags'              => [$tag->id, $tag2->id]
            ]);
            
            $response->assertCreated()
            ->assertJsonPath('data.user.id', $user->id)
            ->assertJsonPath('data.title', 'test office')
            ->assertJsonPath('data.approval_status', Office::APPROVAL_PENDING)
            ;
            

            $this->assertDatabaseHas('offices', ['title' => 'test office']);

            Notification::assertSentTo(
                $user,
                OfficePendingApproval::class
            );
         
         }


         /**
          * it does not allow to create a new office if scope is not provided
          * @test
          * @return void
          */
            public function test_it_does_not_allow_to_create_a_new_office_if_scope_is_not_provided()
            {
                $user = User::factory()->create();
                Sanctum::actingAs($user, ['office.create']);
                $response = $this->postJson('/api/offices');
                $this->assertNotEquals(403, $response->status());
            }


            /**
             * test for update office
             * @test
             * @return void
             */
             public function test_can_update_an_office()
             {
                $user = User::factory()->create();
                $tags = Tag::factory(3)->create();
                $office = Office::factory()->for($user)->create();
        
                $office->tags()->attach($tags);
        
                Sanctum::actingAs($user, ['*']);
        
                $anotherTag = Tag::factory()->create();
        
                $response = $this->putJson('/api/offices/'.$office->id, [
                    'title' => 'Amazing Office',
                    'tags' => [$tags[0]->id, $anotherTag->id]
                ]);
        
                $response->assertOk()
                    ->assertJsonCount(2, 'data.tags')
                    ->assertJsonPath('data.tags.0.id', $tags[0]->id)
                    ->assertJsonPath('data.tags.1.id', $anotherTag->id)
                    ->assertJsonPath('data.title', 'Amazing Office');
             }


             /**
              * test office policy for updating office not belonging to the user
              * @test
              * @return void
              */

              public function test_office_policy_for_updating_office_not_belonging_to_the_user()
              {
                  $user = User::factory()->create();
                  $office = Office::factory()->create();
                  Sanctum::actingAs($user, ['*']);

                  $response = $this->putJson('/api/offices/'.$office->id, [
                      'title'             => 'test office updated22222',
                  ]);
          
                  $response->assertStatus(Response::HTTP_FORBIDDEN);

              
              }


              /**
               * marks the office as unpublished if updated main columns
               * @test
               * @return void
               */
                public function test_marks_the_office_as_unpublished_if_updated_main_columns()
                {
                     $user = User::factory()->create(['is_admin' => true]);
                     Notification::fake();
                     $office = Office::factory()->for($user)->create();
                     Sanctum::actingAs($user, ['*']);
    
                     $response = $this->putJson('/api/offices/'.$office->id, [
                          'title'             => 'dirty dirty',
                          'lat'               => '30.59258882022191',
                     ]);
                
                     $response->assertOk();
                     $this->assertDatabaseHas('offices', ['id' => $office->id, 'approval_status' => Office::APPROVAL_PENDING]);
                     Notification::assertSentTo($user, OfficePendingApproval::class);
                }


                /**
                 * TEST FOR DELETE OFFICE THATS BELONGING TO THE USER
                 * @test
                 * @return void
                 */
                public function test_delete_office_that_belongs_to_the_user()
                {
                    $user = User::factory()->create();
                    $office = Office::factory()->for($user)->create();
                    Sanctum::actingAs($user, ['*']);
                    $response = $this->delete('/api/offices/'.$office->id);
                    $response->assertOk();
                    $this->assertSoftDeleted($office);
                    
                }


                /**
                 * TEST FOR DELETE OFFICE THATS HAVE reservations 
                 * @test
                 * @return void
                 */
                public function test_delete_office_that_have_reservations()
                {
                    $user = User::factory()->create();
                    $office = Office::factory()->for($user)->create();
                    $reservation = Reservation::factory()->for($office)->create();
                    Sanctum::actingAs($user, ['*']);
                    $response = $this->deleteJson('/api/offices/'.$office->id);
                    // $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
                    $response->assertUnprocessable();
                    $this->assertModelExists($office);
                    $this->assertDatabaseHas('offices', ['id' => $office->id, 'deleted_at' => null]);
                }



                /**
                 * list offices including hidden and unapproved if filtering by the current logged in user
                 * @test
                 * @return void
                 */
                public function test_list_offices_including_hidden_and_unapproved_if_filtering_by_the_current_logged_in_user()
                {
                    $user = User::factory()->create();
                    $office = Office::factory(3)->for($user)->create();
                    $office2 = Office::factory()->for($user)->create(['approval_status' => Office::APPROVAL_PENDING]);
                    $office3 = Office::factory()->for($user)->create(['hidden' => true]);
                    
                    Sanctum::actingAs($user, ['*']);


                    $response = $this->getJson('/api/offices?user_id='.$user->id);

                    $response->assertOk()
                    ->assertJsonCount(5, 'data');

                }


                /**
                 * update an office with image
                 * @test
                 * @return void
                 */
                public function test_update_an_office_with_image()
                {
                    $user = User::factory()->create();
                    $office = Office::factory()->for($user)->create();
                    Sanctum::actingAs($user, ['*']);
                    $image = $office->images()->create(['path' => 'image.jpg']);

                    $response = $this->putJson('/api/offices/'.$office->id, [
                        'title' => 'Amazing Office',
                        'featured_image_id' => $image->id
                    ]);

                    $response->assertOk()
                    ->assertJsonPath('data.featured_image_id', $image->id); 

                }

                /**
                 * testing it dosent update the featured image if the image is not in the office
                 * @test
                 * @return void
                 */
                public function test_it_doesnt_update_the_featured_image_if_the_image_is_not_in_the_office()
                {
                    $user = User::factory()->create();
                    $office = Office::factory()->for($user)->create();
                    $office2 = Office::factory()->for($user)->create();
                    Sanctum::actingAs($user, ['*']);
                    $image = $office2->images()->create(['path' => 'image.jpg']);

                    $response = $this->putJson('/api/offices/'.$office->id, [
                        'title' => 'Amazing Office',
                        'featured_image_id' => $image->id
                    ]);

                    $response->assertUnprocessable()->assertInvalid('featured_image_id');
                    $this->assertNotSoftDeleted($office);

                 

                }

                
          
      
     




}
