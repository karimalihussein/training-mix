<?php

namespace App\DesignPatterns\BehavioralPatterns\ChainOfResponsibility\One;

abstract class AbstractTicketHandler implements TicketHandlerInterface
{
    private ?TicketHandlerInterface $nextHandler = null;

    public function setNext(TicketHandlerInterface $handler): TicketHandlerInterface
    {
        $this->nextHandler = $handler;
        return $handler;
    }

    public function handle(string $ticketType): ?string
    {
        if ($this->nextHandler) {
            return $this->nextHandler->handle($ticketType);
        }

        return null;
    }
}
