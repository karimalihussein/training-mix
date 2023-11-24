<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PlanSubscriptionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure(Request): (Response|RedirectResponse) $next
     * @return JsonResponse|Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next): JsonResponse|Response|RedirectResponse
    {
        $tenant = tenant();
        if ($tenant->subscription('main')->isActive() || $tenant->subscription('main')->isOnTrial()) {
            return $next($request);
        }
        return response()->json([
                'message' => 'You are not subscribed to any plan'
        ], 403);
    }
}
