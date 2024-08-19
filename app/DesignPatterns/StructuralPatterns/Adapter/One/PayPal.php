<?php

namespace App\DesignPatterns\StructuralPatterns\Adapter\One;

final class PayPal
{
    public static function charge($amount)
    {
        echo "Charging {$amount} using PayPal" . PHP_EOL;
    }
}
