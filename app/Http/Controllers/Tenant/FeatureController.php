<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\View\View;

class FeatureController extends Controller
{

    public function __construct()
    {
        $this->middleware('tenant:leads_management');
    }

    public function index(Request $request): JsonResource
    {
        return JsonResource::make([
            'message' => 'You are subscribed to the leads_management plan',
            'features' => tenant()->subscription('main')->features
        ]);
    }
}
