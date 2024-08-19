<?php

namespace App\DesignPatterns\BehavioralPatterns\ChainOfResponsibility;

final class ChainOfResponsibilityService
{
    public function run(): void
    {
        $technicalSupportHandler = new One\TechnicalSupportHandler();
        $salesHandler = new One\SalesHandler();
        $billingHandler = new One\BillingHandler();

        $technicalSupportHandler->setNext($salesHandler)->setNext($billingHandler);

        $ticketTypes = ['technical', 'sales', 'billing', 'unknown'];

        foreach ($ticketTypes as $ticketType) {
            echo $technicalSupportHandler->handle($ticketType) . PHP_EOL . "<br>";
        }
    }
}
