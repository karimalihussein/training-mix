<?php

declare(strict_types=1);

namespace App\Services;

interface PaymentGatwayContract
{
    public function setDiscount($amount): void;

    public function charge($amount): array;
}
