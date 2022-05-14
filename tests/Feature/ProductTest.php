<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    /**
     * test products routes
     * @return void
     */
    public function test_products_route_return_ok()
    {
        $response = $this->get('/products');
        $response->assertStatus(200);
    }

    /**
     * product has a name
     * @return void
     */
    public function test_product_has_name()
    {
        $product = Product::factory()->create();
        $this->assertNotNull($product->name); 
        
    }
}
