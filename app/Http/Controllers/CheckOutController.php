<?php

namespace App\Http\Controllers;

use Bpuig\Subby\Models\Plan;
use Bpuig\Subby\Models\PlanFeature;

class CheckOutController extends Controller
{
    public function store()
    {
        $user = auth()->user();
        $features = $user->subscription('main')->plan->features;

        $features->contains('name', 'articles-management');

        // return $user->subscription('main')->features();
        // return $user->subscription('main')->isActive();
        // $plan = Plan::first();
        // return $plan->features;
        // return auth()->user()->subscriptions->first()->plan->hasAnyFeature(['articles-management']);
        // $plan = Plan::create([
        //     'tag' => 'basic',
        //     'name' => 'Basic Plan',
        //     'description' => 'For small businesses',
        //     'price' => 9.99,
        //     'signup_fee' => 1.99,
        //     'invoice_period' => 1,
        //     'invoice_interval' => 'month',
        //     'trial_period' => 15,
        //     'trial_interval' => 'day',
        //     'grace_period' => 1,
        //     'grace_interval' => 'day',
        //     'tier' => 1,
        //     'currency' => 'EUR',
        // ]);

        // return $plan;
        // $user = auth()->user();
        // return $user->subscriptions;
        $plan = Plan::find(1);
        // $plan->features()->saveMany([
        //     new PlanFeature(['tag' => 'social_profiles', 'name' => 'Social profiles available', 'value' => 3, 'sort_order' => 1]),
        //     new PlanFeature(['tag' => 'posts_per_social_profile', 'name' => 'Scheduled posts per profile', 'value' => 30, 'sort_order' => 10, 'resettable_period' => 1, 'resettable_interval' => 'month']),
        //     new PlanFeature(['tag' => 'analytics', 'name' => 'Analytics', 'value' => true, 'sort_order' => 15])
        // ]);
        // return $plan->features->
        // check if the plan has a feature
        // return $plan->features->where('tag', 'social_profiles')->first();
        return $plan->getFeatureBySlug('social_profiles')->value;

        // $user->newSubscription(
        //     'main', // identifier tag of the subscription. If your application offers a single subscription, you might call this 'main' or 'primary'
        //      $plan, // Plan or PlanCombination instance your subscriber is subscribing to
        //      'Main subscription', // Human-readable name for your subscription
        //      'Customer main subscription', // Description
        //      null, // Start date for the subscription, defaults to now()
        //      'free' // Payment method service defined in config
        // );
    }
}
