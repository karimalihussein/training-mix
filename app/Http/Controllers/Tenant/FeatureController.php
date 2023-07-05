<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Repositories\FeatureRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\View\View;

class FeatureController extends Controller
{
    public function __construct(private FeatureRepository $featureRepository)
    {
        $this->middleware('tenant:leads_management');
        $this->featureRepository = $featureRepository;
    }

    public function index(Request $request)
    {
        return $this->featureRepository->store();
    }
}
