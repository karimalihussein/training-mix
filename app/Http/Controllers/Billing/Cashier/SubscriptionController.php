<?php

namespace App\Http\Controllers\Billing\Cashier;

use App\Http\Controllers\Controller;
use App\Http\Resources\PlanResource;
use App\Models\User;
use Bpuig\Subby\Models\Plan;

class SubscriptionController extends Controller
{
    public function subscribe()
    {
        $user = User::query()->first();
        $plan = Plan::query()->first();
        // check if the current user has a subscription and if it is active
        if ($user->hasActiveSubscription()) {
            // if the user has an active subscription, we will cancel it
            $user->subscription('main')->cancel();
        }
        return $user->newSubscription('main', $plan, 'Main subscription', 'Customer main subscription', null, 'free');
    }
}
