<?php

declare(strict_types=1);

namespace App\Services;

class PaymentGatway implements PaymentGatwayContract
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
        return [
            'amount' => $amount - $this->discount,
            'confirmation_number' => 'ABC123',
            'currency' => $this->currency,
            'description' => 'Charge for order #123',
            'source' => 'tok_visa',
            'discount' => $this->discount,
        ];

    }
}
