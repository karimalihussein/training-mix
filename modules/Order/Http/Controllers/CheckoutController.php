<?php

namespace Modules\Order\Http\Controllers;

use Modules\Order\Exceptions\PaymentFailedException;
use Illuminate\Validation\ValidationException;
use Modules\Order\Actions\PurchaseItemsAction;
use Modules\Order\DTO\PendingPayment;
use Modules\Order\Http\Requests\CheckoutRequest;
use Modules\Payment\Services\PayBuddy;
use Modules\Product\DTO\CartItemCollection;
use Modules\User\DTO\UserDto;

final class CheckoutController
{
    public function __construct(protected PurchaseItemsAction $action)
    {
    }

    public function __invoke(CheckoutRequest $request)
    {
        $cartItems = CartItemCollection::fromArray($request->input('products'));
        $pendingPayment = new PendingPayment(PayBuddy::make(), $request->input('payment_token'));
        $userDto = UserDto::fromEloquentModel($request->user());
        try {
            $order =  $this->action->handle(
                items: $cartItems,
                pendingPayment: $pendingPayment,
                user: $userDto,
            );
        } catch (PaymentFailedException $e) {
            throw ValidationException::withMessages([
                'payment_token' => 'we could not charge the payment method provided.',
            ]);
        }
        return response()->json([
            'order_url' => $order->url,
        ], 201);
    }
}
