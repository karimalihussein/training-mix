<?php

namespace App\DesignPatterns\StructuralPatterns\Adapter\One;

final class StripePaymentProcessor implements PaymentProcessor
{
    public function pay($amount)
    {
        Stripe::charge($amount);
    }
}
