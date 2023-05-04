<?php

namespace Tests\Feature;

use App\Models\Product;
use Tests\TestCase;

class ProductTest extends TestCase
{
    /**
     * product has a name
     *
     * @return void
     */
    public function test_product_has_name()
    {
        $product = Product::factory()->create();
        $this->assertNotNull($product->name);
    }
}
