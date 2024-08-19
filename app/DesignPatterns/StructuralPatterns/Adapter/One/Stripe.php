<?php

namespace App\DesignPatterns\StructuralPatterns\Adapter\One;

final class Stripe
{
    public static function charge($amount)
    {
        echo "Charging $amount using Stripe" . PHP_EOL;
    }
}
