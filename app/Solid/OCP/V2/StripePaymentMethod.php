<?php

namespace App\Solid\OCP\V2;

use App\Solid\OCP\V2\Interfaces\PaymentMethodInterface;

class StripePaymentMethod implements PaymentMethodInterface
{
    public function makePayment()
    {
        return 'stripe payment';
    }
}
