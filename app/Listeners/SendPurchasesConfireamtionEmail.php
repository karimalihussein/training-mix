<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendPurchasesConfireamtionEmail
{

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $purchase = $event->purchase;
        $purchase->user->notify(new \App\Notifications\PurchaseConfirmation($purchase));

    }
}
