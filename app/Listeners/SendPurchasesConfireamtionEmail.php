<?php

declare(strict_types=1);

namespace App\Listeners;

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
