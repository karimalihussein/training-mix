<?php

declare(strict_types=1);

namespace App\Solid\OCP\V2\Interfaces;

interface PaymentMethodInterface
{
    public function makePayment();
}
