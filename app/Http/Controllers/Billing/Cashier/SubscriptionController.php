<?php

namespace App\Http\Controllers\Billing\Cashier;

use App\Http\Controllers\Controller;
use App\Http\Resources\PlanResource;
use App\Models\User;
use Bpuig\Subby\Models\Plan;

class SubscriptionController extends Controller
{
    public function subscribe(int $id)
    {
        $user = User::query()->first();
        $plan = Plan::query()->find($id);
        if($user->useTrailPeriodBefore())
        {
            if($user->onTrialPeriod())
            {
                return response()->json([
                    'message' => 'You are already on trial period, you can not subscribe to another plan',
                ], 403);
            }
//            return response()->json([
//                'message' => 'you have to pay for this plan,because you have used your free trial period',
//            ], 403);
            return $user->newPremiumSubscription('main', $plan, 'Default subscription', 'Customer default subscription');
        }
        return $user->newSubscription('on_trial', $plan, 'On trial subscription', 'Customer on trial subscription', null, 'trial');

    }

    public function useFreeTrial()
    {
        $user = User::query()->first();
        $plan = Plan::query()->find(1);
        return $user->newSubscription('on_trial', $plan, 'On trial subscription', 'Customer on trial subscription', null, 'trial');
    }

    public function mySubscription()
    {
        $user = User::query()->first();
        return $user->subscription();
    }

    public function mySubscriptionsDetails(): array
    {
        $user = User::query()->first();
        return [
            'trial_start_date' => $user->subscription()->getTrialStartDate()->format('Y-m-d H:i:s'),
            'trial_total_duration' => $user->subscription()->getTrialTotalDurationIn('day'),
            'trial_period_usage' => $user->subscription()->getTrialPeriodUsageIn('day'),
            'trial_period_remaining_usage' => $user->subscription()->getTrialPeriodRemainingUsageIn('day'),
            'is_free' => $user->subscription()->isFree(),
        ];
    }
}
