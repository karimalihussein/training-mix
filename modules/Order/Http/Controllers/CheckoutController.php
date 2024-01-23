<?php

namespace Modules\Order\Http\Controllers;

use Modules\Payment\Exceptions\PaymentFailedException;
use Illuminate\Validation\ValidationException;
use Modules\Order\Actions\PurchaseItemsAction;
use Modules\Order\DTO\PendingPayment;
use Modules\Order\Http\Requests\CheckoutRequest;
use Modules\Payment\PaymentGatway;
use Modules\Product\DTO\CartItemCollection;
use Modules\User\DTO\UserDto;

final class CheckoutController
{
    public function __construct(
        protected PurchaseItemsAction $action,
        protected PaymentGatway $paymentGetway,
    ) {
    }

    public function __invoke(CheckoutRequest $request)
    {
        $cartItems = CartItemCollection::fromArray($request->input('products'));
        $pendingPayment = new PendingPayment($this->paymentGetway, $request->input('payment_token'));
        $userDto = UserDto::fromEloquentModel($request->user());
        try {
            $order =  $this->action->handle(
                items: $cartItems,
                pendingPayment: $pendingPayment,
                user: $userDto,
            );
        } catch (PaymentFailedException) {
            throw ValidationException::withMessages([
                'payment_token' => 'we could not charge the payment method provided.',
            ]);
        }
        return response()->json([
            'order_url' => $order->url,
        ], 201);
    }
}