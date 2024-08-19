<?php

namespace App\DesignPatterns\StructuralPatterns\Adapter;
use App\DesignPatterns\StructuralPatterns\Adapter\One\PayPalPaymentProcessor;
use App\DesignPatterns\StructuralPatterns\Adapter\One\StripePaymentProcessor;


final class AdapterService
{
    public function handle()
    {
        $stripe = new StripePaymentProcessor();
        $stripe->pay(100);

        $paypal = new PayPalPaymentProcessor();
        $paypal->pay(100);
    }
}
