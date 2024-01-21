<?php

namespace Modules\Order\Tests\Http\Controllers;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Modules\Order\Models\Order;
use Modules\Payment\Services\PayBuddy;
use Modules\Product\Database\Factories\ProductFactory;
use Tests\TestCase;

final class CheckoutControllerTest extends TestCase
{
    /** @test */
    public function it_successfuly_creates_an_order(): void
    {
        $user = UserFactory::new()->create();
        $products = ProductFactory::new()->count(2)->create(
            new Sequence(
                ['name' => 'Iphone 15 Pro Max', 'price_in_cents' => 10000, 'stock' => 10],
                ['name' => 'Macbook Pro m3', 'price_in_cents' => 50000, 'stock' => 10],
            )
        );

        $paymentToken = PayBuddy::validToken();

        $response = $this->actingAs($user)->postJson(route('checkout.store'), [
            'products' => [
                ['id' => $products->first()->id, 'quantity' => 1],
                ['id' => $products->last()->id, 'quantity' => 1],
            ],
            'payment_token' => $paymentToken,
        ]);

        $response->assertCreated();
        $order = Order::query()->latest()->first();
        // order
        $this->assertTrue($order->user->is($user));
        $this->assertSame('completed', $order->status);
        $this->assertEquals(60000, $order->total_in_cents);
        $this->assertSame('paybuddy', $order->payment_gateway);
        // payment
        $payment = $order->lastPayment;
        $this->assertSame('paid', $payment->status);
        $this->assertSame('paybuddy', $payment->payment_gateway);
        $this->assertTrue($payment->user->is($user));

        $this->assertCount(2, $order->lines);

        foreach ($products as $product) {
            $orderLine = $order->lines->firstWhere('product_id', $product->id);
            $this->assertSame($product->price_in_cents, $orderLine->price_in_cents);
            $this->assertSame(1, $orderLine->quantity);
        }

        $products = $products->fresh();

        $this->assertSame(9, $products->first()->stock);
        $this->assertSame(9, $products->last()->stock);
    }

    /** @test */
    public function it_fails_to_create_an_order_when_the_payment_token_is_invalid(): void
    {
        $user = UserFactory::new()->create();
        $product = ProductFactory::new()->count(2)->create(
            new Sequence(
                ['name' => 'Iphone 15 Pro Max', 'price_in_cents' => 10000, 'stock' => 10],
                ['name' => 'Macbook Pro m3', 'price_in_cents' => 50000, 'stock' => 10],
            )
        );

        $response = $this->actingAs($user)->postJson(route('checkout.store'), [
            'products' => [
                ['id' => $product->first()->id, 'quantity' => 1],
                ['id' => $product->last()->id, 'quantity' => 1],
            ],
            'payment_token' => PayBuddy::invalidToken(),
        ])->assertUnprocessable();
        $response->assertJsonValidationErrors('payment_token');
    }
}
