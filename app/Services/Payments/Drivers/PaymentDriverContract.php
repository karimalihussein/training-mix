<?php

namespace App\Services\Payments\Drivers;

interface PaymentDriverContract
{
    public function pay(float|int $amount): string;

    public function refund(float|int $amount): string;
}