<?php

namespace Modules\Payment;

use Modules\Payment\DTO\PaymentDetails;
use Modules\Payment\DTO\SuccessfulPaymentResponse;
use Modules\Payment\Enums\PaymentProvider;

readonly final class InMemoryGetway implements PaymentGatway
{
    public function charge(PaymentDetails $paymentDetails): SuccessfulPaymentResponse
    {
        return new SuccessfulPaymentResponse(
            id: 'in_memory_payment_id',
            amountInCents: $paymentDetails->amountInCents,
            paymentProvider: PaymentProvider::InMemory,
        );
    }

    public function id(): PaymentProvider
    {
        return PaymentProvider::InMemory;
    }
}