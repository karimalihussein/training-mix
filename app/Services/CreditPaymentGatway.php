<?php

declare(strict_types=1);

namespace App\Services;

class CreditPaymentGatway implements PaymentGatwayContract
{
    private string $currency;

    private $discount;

    public function __construct($currency)
    {
        $this->currency = $currency;
        $this->discount = 0;
    }

    public function setDiscount($amount): void
    {
        $this->discount = $amount;
    }

    public function charge($amount): array
    {
        $fees = $amount * 0.05;

        return [
            'amount' => ($amount - $this->discount) + $fees,
            'confirmation_number' => 'ABC123',
            'currency' => $this->currency,
            'description' => 'Charge for order #123',
            'source' => 'credit_payment',
            'discount' => $this->discount,
            'fees' => $fees,
        ];

    }
}
