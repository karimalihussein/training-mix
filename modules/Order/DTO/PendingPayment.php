<?php

namespace Modules\Order\DTO;

use Modules\Payment\PaymentGatway;

readonly final class PendingPayment
{
    public function __construct(
        public PaymentGatway $provider,
        public string $paymentToken,
    ) {
    }
}