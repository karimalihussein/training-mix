<?php

namespace App\Services\Payments;

use App\Services\Payments\Drivers\PaypalDriver;
use App\Services\Payments\Drivers\StripeDriver;
use Illuminate\Support\Manager;

class PaymentGetawayManager extends Manager
{
    public function getDefaultDriver()
    {
        return 'paypal';
    }

    public function createPaypalDriver()
    {
        return new PaypalDriver();
    }

    public function createStripeDriver()
    {
        return new StripeDriver();
    }
}
