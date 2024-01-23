<?php

namespace Modules\Payment\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Payment\PayBuddyGetway;
use Modules\Payment\PayBuddySDK;
use Modules\Payment\PaymentGatway;

final class PaymentServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->mergeConfigFrom(__DIR__ . '/../../config.php', 'payment');
        $this->app->bind(PaymentGatway::class, fn () => new PayBuddyGetway(new PayBuddySDK()));
    }
}