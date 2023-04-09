<?php

namespace App\Solid\V2;

use App\Solid\V1\Interfaces\PaymentMethodInterface;

class PaymentService
{
    public function pay(PaymentMethodInterface $paymentMethod)
    {
        return $paymentMethod->makePayment();
    }
}