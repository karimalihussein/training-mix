<?php

namespace Modules\Order\Http\Controllers;

use Modules\Order\Exceptions\PaymentFailedException;
use Illuminate\Validation\ValidationException;
use Modules\Order\Actions\PurchaseItemsAction;
use Modules\Order\Http\Requests\CheckoutRequest;
use Modules\Payment\Services\PayBuddy;
use Modules\Product\DTO\CartItemCollection;

final class CheckoutController
{
    public function __construct(protected PurchaseItemsAction $action)
    {
    }

    public function __invoke(CheckoutRequest $request)
    {
        $cartItems = CartItemCollection::fromArray($request->input('products'));
        try {
            $this->action->handle(
                $cartItems,
                PayBuddy::make(),
                $request->input('payment_token'),
                $request->user()->id
            );
        } catch (PaymentFailedException $e) {
            throw ValidationException::withMessages([
                'payment_token' => 'we could not charge the payment method provided.',
            ]);
        }
        return response()->json([
            'message' => 'Order created successfully.',
        ], 201);
    }
}