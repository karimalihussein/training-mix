<?php

namespace App\Solid\V2;

use App\Solid\V1\Interfaces\PaymentMethodInterface;

class StripePaymentMethod implements PaymentMethodInterface
{
    public function makePayment()
    {
        return 'stripe payment';
    }
}