<?php

namespace App\Http\Controllers;

use App\Models\Tenant\Customer;
use App\Models\User;
use App\Models\Tenant\Tenant;
use App\Http\Controllers\Controller;
use Bpuig\Subby\Models\Plan;
use Bpuig\Subby\Models\PlanSubscription;
use Nafezly\Payments\Classes\PaymobPayment;
use Nafezly\Payments\Classes\PayPalPayment;

class TestController extends Controller
{

    public function index()
    {
        $payment = new PaymobPayment();
        $paypal = new PayPalPayment();
        dd($payment);
        // $randomTime = time();
        // return $randomTime;
        // return $amountOfPosts = PlanSubscription::find(1)->getFeatureValue('leads_management');
        // return Plan::query()->where('tag', 'free')->first()->features->where('tag', 'leads_management')->first()->value;
        // $tenant = Tenant::query()->first();
        // $customer = Customer::query()->first();
        // // $tenant->newPlanSubscription('main', Plan::query()->first());
        // // $user = User::query()->first();
        // // dd($user->subscription('main')->isOnTrial());
        // $plan = Plan::query()->find(2);
        // // $user->newSubscription('main', $plan, 'Main subscription', 'Customer main subscription');
        // $tenant->newSubscription('main', $plan, 'Main subscription', 'Customer main subscription', now(), 'paid');
//         $plan = Plan::query()->first();
        // return $plan;
        // $user = User::query()->first();
        // return $user->onTrialPeriod;
        // return $user;
//         return $user->newSubscription('main three', $plan, 'Main subscription', 'Customer main subscription');
        // return $user->activeSubscriptions();
    }

    public function payment()
    {
        $paypal = new PayPalPayment();
        return $paypal->pay(100, 1, 'Ahmed', 'Mohamed', 'ahmedmohamed@gmail.com', '01000000000', 'paypal');
    }
}
