<?php

namespace Modules\Order\Actions;

use Modules\Payment\Exceptions\PaymentFailedException;
use Modules\Payment\DTO\PaymentDetails;
use Modules\Payment\Models\Payment;
use Modules\Payment\PaymentGatway;
use RuntimeException;

final class CreatePaymentForOrderAction
{
    public function handle(
        int $orderId,
        int $userId,
        int $totalInCents,
        PaymentGatway $paymentGatway,
        string $paymentToken
    ): Payment {
        $charge = $paymentGatway->charge(
            new PaymentDetails(
                token: $paymentToken,
                amountInCents: $totalInCents,
                statementDescription: 'Laravel Shop',
            )
        );
        return Payment::query()->create([
            'total_in_cents'  => $totalInCents,
            'status'          => 'paid',
            'payment_id'      => $charge->id,
            'payment_gateway' => $charge->paymentProvider,
            'user_id'         => $userId,
            'order_id'        => $orderId,
        ]);
    }
}