<?php

declare(strict_types=1);

namespace Modules\Order\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as BaseEventServiceProvider;
use Modules\Order\Events\OrderCreated;
use Modules\Order\Listeners\SendOrderCreatedNotification;

final class EventServiceProvider extends BaseEventServiceProvider
{
    protected $listen = [
        OrderCreated::class => [
            SendOrderCreatedNotification::class,
        ],
    ];
}