<?php

namespace App\Services\Payments\Drivers;

final class StripeDriver implements PaymentDriverContract
{
    public function pay(float|int $amount): string
    {
        return "Paying {$amount} using Stripe";
    }

    public function refund(float|int $amount): string
    {
        return "Refunding {$amount} using Stripe";
    }
}
