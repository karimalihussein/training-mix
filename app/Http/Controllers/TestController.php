<?php

namespace App\Http\Controllers;

use App\Models\Tenant\Customer;
use App\Models\User;
use App\Models\Tenant\Tenant;
use App\Http\Controllers\Controller;
use Bpuig\Subby\Models\Plan;

class TestController extends Controller
{

    public function __invoke()
    {
        // return Plan::query()->where('tag', 'free')->first()->features->where('tag', 'leads_management')->first()->value;
        // $tenant = Tenant::query()->first();
        // $customer = Customer::query()->first();
        // // $tenant->newPlanSubscription('main', Plan::query()->first());
        // // $user = User::query()->first();
        // // dd($user->subscription('main')->isOnTrial());
        // $plan = Plan::query()->find(2);
        // // $user->newSubscription('main', $plan, 'Main subscription', 'Customer main subscription');
        // $tenant->newSubscription('main', $plan, 'Main subscription', 'Customer main subscription', now(), 'paid');
        $plan = Plan::query()->first();
        // return $plan;
        $user = User::query()->first();
        // return $user;
        return $user->newSubscription('main', $plan->id, 'Main subscription', 'Customer main subscription', now(), 'paid');
    }
}
