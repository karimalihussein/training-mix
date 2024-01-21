<?php

namespace Modules\Order\Http\Controllers;

use Illuminate\Validation\ValidationException;
use Modules\Order\Http\Requests\CheckoutRequest;
use Modules\Order\Models\Order;
use Modules\Payment\Services\PayBuddy;
use Modules\Product\DTO\CartItemCollection;
use Modules\Product\Warehouse\ProductStockManager;
use RuntimeException;

final class CheckoutController
{
    public function __construct(protected ProductStockManager $productStockManager)
    {
    }

    public function __invoke(CheckoutRequest $request)
    {
        $cartItems         = CartItemCollection::fromArray($request->input('products'));
        $orderTotalInCents = $cartItems->totalInCents();
        $payBuddy          = PayBuddy::make();
        try {
            $charge = $payBuddy->charge($request->input('payment_token'), $orderTotalInCents, 'Laravel Shop');
        } catch (RuntimeException) {
            throw ValidationException::withMessages([
                'payment_token' => 'We were unable to process your order.',
            ]);
        }
        $order = Order::query()->create([
            'payment_id'      => $charge['id'],
            'status'          => 'completed',
            'total_in_cents'  => $orderTotalInCents,
            'payment_gateway' => 'paybuddy',
            'user_id'         => $request->user()->id,
        ]);

        foreach ($cartItems->items() as $cartItem) {
            $this->productStockManager->decremnt($cartItem->product->id, $cartItem->quantity);

            $order->lines()->create([
                'product_id'     => $cartItem->product->id,
                'quantity'       => $cartItem->quantity,
                'price_in_cents' => $cartItem->product->priceInCents,
            ]);
        }

        $order->payments()->create([
            'total_in_cents' => $orderTotalInCents,
            'status'         => 'paid',
            'payment_id'     => $charge['id'],
            'payment_gateway' => 'paybuddy',
            'user_id'         => $request->user()->id,
        ]);

        return response()->json([
            'message' => 'Order created successfully.',
            'order'   => $order,
        ], 201);
    }
}
