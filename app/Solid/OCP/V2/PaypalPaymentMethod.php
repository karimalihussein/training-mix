<?php

declare(strict_types=1);

namespace App\Solid\OCP\V2;

use App\Solid\OCP\V2\Interfaces\PaymentMethodInterface;

class PaypalPaymentMethod implements PaymentMethodInterface
{
    public function makePayment()
    {
        return 'Paypal payment';
    }
}
