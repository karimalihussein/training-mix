<?php

declare(strict_types=1);

namespace App\Solid\OCP\V2;

use App\Solid\OCP\V2\Interfaces\PaymentMethodInterface;

class PaymentService
{
    public function pay(PaymentMethodInterface $paymentMethod)
    {
        return $paymentMethod->makePayment();
    }
}
