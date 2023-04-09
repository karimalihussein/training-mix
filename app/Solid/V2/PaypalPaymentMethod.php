<?php

namespace App\Solid\V2;

use App\Solid\V1\Interfaces\PaymentMethodInterface;

class PaypalPaymentMethod implements PaymentMethodInterface
{
    public function makePayment()
    {
        return 'Paypal payment';
    }
}