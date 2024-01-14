<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;
use App\Services\Payments\PaymentGetawayManager;
use App\Services\Payments\Drivers\PaymentDriverContract;

/**
 * @method static PaymentDriverContract driver(string $driver = null)
 * @method static string pay(float|int $amount)
 * @method static string refund(float|int $amount)
 *
 * @see PaymentGetawayManager
 */
class Payment extends Facade
{
    protected static function getFacadeAccessor()
    {
        return PaymentGetawayManager::class;
    }
}
