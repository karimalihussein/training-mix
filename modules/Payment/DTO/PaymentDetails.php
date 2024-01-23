<?php

namespace Modules\Payment\DTO;

readonly final class PaymentDetails
{
    public function __construct(
        public string $token,
        public int $amountInCents,
        public string $statementDescription,
    ) {
    }
}