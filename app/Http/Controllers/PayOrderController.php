<?php

namespace App\Http\Controllers;

use App\Services\OrderDetails;
use App\Services\PaymentGatwayContract;

class PayOrderController extends Controller
{
    public function store(OrderDetails $order, PaymentGatwayContract $payment)
    {
        $order = $order->all();

        return $payment->charge(2500);

    }
}
