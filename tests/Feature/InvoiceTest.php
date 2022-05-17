<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InvoiceTest extends TestCase
{
    /**
     * test to create the invoice from existing order
     * @return void
     */
    public function test_invoice_created_successfully()
    {


        $user = User::factory()->create();

        $order = $user->orders()->create([
            'details' => 'test for order',
        ]);

        $response = $this->actingAs($user)->postJson('/api/invoices/' . $order->id);

        $response->assertStatus(200);

    
    }

    public function test_duplicate_invoice_throws_validation_error()
    {
        $user = User::factory()->create();
        $order = $user->orders()->create([
            'details' => 'test for order',
        
        ]);

        $response = $this->postJson('/api/invoices/' . $order->id);

        $response->assertStatus(200);

        $response = $this->postJson('/api/invoices/' . $order->id);

        $response->assertStatus(422);
    }



     
}
