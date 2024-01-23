<?php

namespace Modules\Payment\DTO;

use Modules\Payment\Enums\PaymentProvider;

readonly final class SuccessfulPaymentResponse
{
    public function __construct(
        public string $id,
        public int $amountInCents,
        public PaymentProvider $paymentProvider,
    ) {
    }
}