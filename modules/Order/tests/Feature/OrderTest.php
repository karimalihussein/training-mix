<?php

namespace Modules\Order\Tests\Feature;

use Modules\Order\Models\Order;
use Tests\TestCase;

class OrderTest extends TestCase
{
    /** @test */
    public function it_can_create_an_order()
    {
        $order = Order::factory()->create();
        $this->assertDatabaseHas('modules_orders', [
            'id' => $order->id,
        ]);
    }
}
