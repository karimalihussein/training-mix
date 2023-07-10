<?php

namespace App\Http\Controllers\Billing\Cashier;

use App\Http\Controllers\Controller;
use App\Http\Resources\PlanResource;
use Bpuig\Subby\Models\Plan;

class PlanController extends Controller
{
    public function index(): \Illuminate\Http\JsonResponse
    {
        return PlanResource::collection(Plan::all())->response();
    }

    public function show(int $id): \Illuminate\Http\JsonResponse
    {
        $plan = Plan::findOrFail($id);
        return (new PlanResource($plan->load('features')))->response();
    }
}
