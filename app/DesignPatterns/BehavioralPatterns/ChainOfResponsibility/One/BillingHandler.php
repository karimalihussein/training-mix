<?php

namespace App\DesignPatterns\BehavioralPatterns\ChainOfResponsibility\One;

class BillingHandler extends AbstractTicketHandler
{
    public function handle(string $ticketType): ?string
    {
        if ($ticketType === 'billing') {
            return 'Billing department will handle this ticket.';
        }

        return parent::handle($ticketType);
    }
}
