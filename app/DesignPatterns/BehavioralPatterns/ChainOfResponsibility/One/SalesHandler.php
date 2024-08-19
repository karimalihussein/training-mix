<?php
namespace App\DesignPatterns\BehavioralPatterns\ChainOfResponsibility\One;

class SalesHandler extends AbstractTicketHandler
{
    public function handle(string $ticketType): ?string
    {
        if ($ticketType === 'sales') {
            return 'Sales department will handle this ticket.';
        }

        return parent::handle($ticketType);
    }
}
