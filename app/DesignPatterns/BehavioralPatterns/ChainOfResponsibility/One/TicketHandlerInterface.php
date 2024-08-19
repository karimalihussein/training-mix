<?php

namespace App\DesignPatterns\BehavioralPatterns\ChainOfResponsibility\One;
interface TicketHandlerInterface
{
    public function setNext(TicketHandlerInterface $handler): TicketHandlerInterface;

    public function handle(string $ticketType): ?string;
}
