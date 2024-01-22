<?php

namespace Modules\Order\Listeners;

use Illuminate\Support\Facades\Mail;
use Modules\Order\Events\OrderCreated;

final class SendOrderCreatedNotification
{
    public function handle(OrderCreated $event): void
    {
        Mail::to($event->user->email)->queue(new \Modules\Order\Mail\OrderCreated($event->order->id, $event->order->localizedTotal));
    }
}
