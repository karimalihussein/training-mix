<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;

class PlanFeaturesSubscriptionForMaxRecordsMiddleware
{
    public function handle($request, Closure $next, $feature, $guard = null)
    {

        $tenant = tenant();
        //        foreach ($features as $feature) {
        //            if($tenant->subscription('main')->canUseFeature($feature)) {
        //                return $next($request);
        //            }
        //        }
        $value = tenant()->subscription('main')->getFeatureByTag($feature)->value;



    }

}
