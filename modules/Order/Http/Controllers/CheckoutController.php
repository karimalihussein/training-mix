<?php

namespace Modules\Order\Http\Controllers;

use Illuminate\Validation\ValidationException;
use Modules\Order\Http\Requests\CheckoutRequest;
use Modules\Order\Models\Order;
use Modules\Payment\Services\PayBuddy;
use Modules\Product\Models\Product;
use RuntimeException;

final class CheckoutController
{
    public function __invoke(CheckoutRequest $request)
    {
        $prodcuts = collect($request->input('products'))->map(function ($product) {
            return [
                'product' => Product::findOrFail($product['id']),
                'quantity' => $product['quantity'],
            ];
        });
        $orderTotalInCents = $prodcuts->sum(fn ($product) => $product['product']->price_in_cents * $product['quantity']);
        $payBuddy = PayBuddy::make();
        try {
            $charge = $payBuddy->charge($request->input('payment_token'), $orderTotalInCents, 'Laravel Shop');
        } catch (RuntimeException) {
            throw ValidationException::withMessages([
                'payment_token' => 'We were unable to process your order.',
            ]);
        }
        $order = Order::query()->create([
            'payment_id' => $charge['id'],
            'status' => 'paid',
            'total_in_cents' => $orderTotalInCents,
            'payment_gateway' => 'paybuddy',
            'user_id' => $request->user()->id,
        ]);

        $prodcuts->each(function ($product) use ($order) {

            if ($product['product']->stock < $product['quantity']) {
                throw ValidationException::withMessages([
                    'products' => 'We do not have enough stock to fulfill your order.',
                ]);
            }

            $product['product']->decrement('stock', $product['quantity']);


            $order->lines()->create([
                'product_id' => $product['product']->id,
                'quantity' => $product['quantity'],
                'price_in_cents' => $product['product']->price_in_cents,
            ]);
        });

        return response()->json([
            'message' => 'Order created successfully.',
            'order' => $order,
        ], 201);
    }
}
