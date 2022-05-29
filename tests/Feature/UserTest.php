<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UserTest extends TestCase
{
    use LazilyRefreshDatabase;
    /**
     * A basic feature redirect after authentication.
     *
     * @return void
     */
    public function test_login_redirect_to_database()
    {
      $uesr =  User::factory()->create([
            'name'        => 'John Doe',
            'email'       => 'test@test.com',
            'password'    => bcrypt('secret'),
        ]);

        $response = $this->post('/login', [
            'email' => $uesr->email,
            'password' => 'secret',
        ]);

        Sanctum::actingAs($uesr, ['*']);

        // $response->assertRedirect('/dashboard');

       
    }


    /**
     * auth user can access the dashboard
     * @return void
     */
    public function test_auth_user_can_access_the_dashboard()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/dashboard');
        $response->assertStatus(200);
    }

    /**
     * guest user can not access the dashboard
     * @return void
     */
    public function test_guest_user_can_not_access_the_dashboard()
    {
        $response = $this->get('/dashboard');
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * user has name attribute
     */
    public function test_user_has_name_attribute()
    {
        $user = User::factory()->create(['name'  => 'John']);
        $this->assertEquals(strtoupper('john'), $user->name);
    }



}
