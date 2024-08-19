<?php
namespace App\DesignPatterns\BehavioralPatterns\ChainOfResponsibility\One;

class TechnicalSupportHandler extends AbstractTicketHandler
{
    public function handle(string $ticketType): ?string
    {
        if ($ticketType === 'technical') {
            return 'Technical Support department will handle this ticket.';
        }

        return parent::handle($ticketType);
    }
}

