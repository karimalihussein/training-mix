<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Booking\Providers\BookingServiceProvider;
use Modules\Order\Providers\OrderServiceProvider;
use Modules\Payment\Infrastructure\Providers\PaymentServiceProvider;
use Modules\Product\Providers\ProductServiceProvider;
use Modules\Shipment\Providers\ShipmentServiceProvider;

final class ModularServiesProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->register(ProductServiceProvider::class);
        $this->app->register(OrderServiceProvider::class);
        $this->app->register(PaymentServiceProvider::class);
        $this->app->register(ShipmentServiceProvider::class);
        $this->app->register(BookingServiceProvider::class);
    }
}