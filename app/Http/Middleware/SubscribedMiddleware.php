<?php

namespace App\Http\Middleware;

use App\Exceptions\PlanUnauthorizedException;
use Closure;

class SubscribedMiddleware
{
    public function handle($request, Closure $next, $features, $guard = null)
    {
        $authGuard = app('auth')->guard($guard);
        if ($authGuard->guest()) {
            throw PlanUnauthorizedException::notLoggedIn();
        }

        if(!$authGuard->user()->subscription('main')->isActive())
        {
            return redirect()->route('plans');
        }

        $features = is_array($features)
            ? $features
            : explode('|', $features);

        foreach ($features as $permission) 
        {
           if($authGuard->user()->subscription('main')->plan->features->contains('tag', $permission))
            {
                return $next($request);
            }
        }

        throw PlanUnauthorizedException::forFeatures($features);

    }
}
