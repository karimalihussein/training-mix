<?php

declare(strict_types=1);

namespace Modules\Product\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as BaseEventServiceProvider;
use Modules\Order\Events\OrderCreated;
use Modules\Order\Listeners\SendOrderCreatedNotification;
use Modules\Product\Listeners\DecreaseProductStock;

final class EventServiceProvider extends BaseEventServiceProvider
{
    protected $listen = [
        OrderCreated::class => [
            DecreaseProductStock::class,
        ],
    ];
}
