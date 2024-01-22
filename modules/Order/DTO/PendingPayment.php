<?php

namespace Modules\Order\DTO;

use Modules\Payment\Services\PayBuddy;

readonly final class PendingPayment
{
    public function __construct(
        public PayBuddy $provider,
        public string $paymentToken,
    ) {
    }
}
