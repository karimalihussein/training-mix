<?php

namespace App\DesignPatterns\StructuralPatterns\Adapter\One;

final class PayPalPaymentProcessor implements PaymentProcessor
{
    public function pay($amount)
    {
        PayPal::charge($amount);
    }
}
