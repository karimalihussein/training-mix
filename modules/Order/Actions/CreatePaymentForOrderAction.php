<?php

namespace Modules\Order\Actions;

use Modules\Payment\Services\PayBuddy;
use Modules\Order\Exceptions\PaymentFailedException;
use Modules\Payment\Models\Payment;
use RuntimeException;

final class CreatePaymentForOrderAction
{
    public function handle(
        int $orderId,
        int $userId,
        int $totalInCents,
        PayBuddy $payBuddy,
        string $paymentToken
    ): Payment {
        try {
            $charge = $payBuddy->charge($paymentToken, $totalInCents, 'Laravel Shop');
        } catch (RuntimeException) {
            throw PaymentFailedException::dueToInvalidToken();
        }

        return Payment::query()->create([
            'total_in_cents' => $totalInCents,
            'status'         => 'paid',
            'payment_id'     => $charge['id'],
            'payment_gateway' => 'paybuddy',
            'user_id'         => $userId,
            'order_id'         => $orderId,
        ]);
    }
}