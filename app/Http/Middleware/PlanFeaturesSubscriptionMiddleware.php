<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;

class PlanFeaturesSubscriptionMiddleware
{
    public function handle($request, Closure $next, $feature, $guard = null)
    {
        $features = is_array($feature) ? $feature : explode('|', $feature);
        $tenant = tenant();
        foreach ($features as $feature) {
            if ($tenant->subscription('main')->canUseFeature($feature)) {
                $request->merge(['access_feature_value' => $tenant->subscription('main')->features->where('tag', $feature)->first()->value]);
                return $next($request);
            }
        }
        return new JsonResponse([
            'message' => 'You are not subscribed to this feature plan.',
        ], 402);
    }
}
