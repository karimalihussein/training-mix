<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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


