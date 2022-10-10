<?php

namespace App\Http\Controllers\Integrations\Payments;

use App\Billing\HyperPayBilling;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Devinweb\LaravelHyperpay\Facades\LaravelHyperpay;

class HyperpayController extends Controller
{
    public function checkout(Request $request)
    {
        $trackable = [
            'product_id'        => rand(1, 999999999),
            'product_type'      => 't-shirt'
        ];
        $user = User::first();
        $amount = 10;
        $brand = 'VISA'; 
        $data = LaravelHyperpay::addBilling(new HyperPayBilling($request))->checkout($trackable, $user, $amount, $brand, $request);
        $res = (json_decode(json_encode($data->original), true));
        return view('integrations.payments.hyperpay.checkout', compact('res'));
    }



    public function callback(Request $request)
    {
        $resourcePath = $request->get('resourcePath');
        $checkout_id = $request->get('id');
        return LaravelHyperpay::paymentStatus($resourcePath, $checkout_id);
    }
}
