<?php

namespace App\Services\Payments\Drivers;

final class PaypalDriver implements PaymentDriverContract
{
    public function pay(float|int $amount): string
    {
        return "Paying {$amount} using Paypal";
    }

    public function refund(float|int $amount): string
    {
        return "Refunding {$amount} using Paypal";
    }
}
