<?php

namespace App\Services\Payments;

use App\Services\Payments\Drivers\PaymentDriverContract;
use Illuminate\Support\ServiceProvider;

final class PaymentServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(PaymentDriverContract::class, function ($app) {
            return new PaymentGetawayManager($app);
        });
    }
}
