<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Tenant\Tenant;
use App\Http\Controllers\Controller;
use Bpuig\Subby\Models\Plan;

class TestController extends Controller
{

    public function __invoke()
    {
        $tenant = Tenant::query()->first();
        // $tenant->newPlanSubscription('main', Plan::query()->first());
        $user = User::query()->first();
        $plan = Plan::query()->first();
        $user->newSubscription('main', $plan, 'Main subscription', 'Customer main subscription');
    }
}
