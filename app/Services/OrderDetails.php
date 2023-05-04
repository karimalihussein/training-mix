<?php

namespace App\Services;

class OrderDetails
{
    private $paymentGatway;

    public function __construct(PaymentGatwayContract $paymentGatway)
    {
        $this->paymentGatway = $paymentGatway;
    }

    public function all()
    {
        $this->paymentGatway->setDiscount(500);

        return [
            'name' => 'John Doe',
            'address' => '123 Main St.',
        ];
    }
}
