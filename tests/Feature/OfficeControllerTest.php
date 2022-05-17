<?php

namespace Tests\Feature;

use App\Models\Office;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OfficeControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        Office::factory(10)->create();
        $response = $this->get('/api/offices');

        $response->assertStatus(200);

        $this->assertCount(10, $response->json('data'));

    

       
    }
}
