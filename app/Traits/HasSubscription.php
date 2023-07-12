<?php

namespace App\Traits;

use App\Services\Subscriptions\SubscriptionPeriod;
use Bpuig\Subby\Models\Plan;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Model;

trait HasSubscription
{
    public function useTrailPeriodBefore(): bool
    {
        return (bool)$this->subscriptions()->whereNotNull('trial_ends_at')->exists();
    }

    public function onTrialPeriod(): bool
    {
        return (bool)$this->subscriptions()->where('trial_ends_at', '>', now())->exists();
    }

    /**
     * @throws Exception
     */
    public function newPremiumSubscription(?string $tag, Plan $plan, ?string $name = null, ?string $description = null, ?Carbon $startDate = null, $paymentMethod = 'free'): Model
    {
        $tag = $tag ?? config('subby.main_subscription_tag');
        $subscriptionPeriod = new SubscriptionPeriod($plan, $startDate ?? now());
        $subscription = $this->subscriptions()->create([
            'tag' => $tag,
            'name' => $name,
            'description' => $description,
            'plan_id' => $plan->id,
            'price' => $plan->price,
            'currency' => $plan->currency,
            'tier' => $plan->tier,
            'trial_interval' => $plan->trial_interval,
            'trial_period' => $plan->trial_period,
            'grace_interval' => $plan->grace_interval,
            'grace_period' => $plan->grace_period,
            'invoice_interval' => $plan->invoice_interval,
            'invoice_period' => $plan->invoice_period,
            'payment_method' => $paymentMethod,
            'starts_at' => $subscriptionPeriod->getStartDate(),
            'ends_at' => $subscriptionPeriod->getEndDate(),
        ]);
        $subscription->syncPlanFeatures($plan);
        return $subscription;
    }
}
