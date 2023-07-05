<?php

namespace App\Repositories;

use App\Models\Tenant\User;
use App\Services\Tenant\MaxReachedService;
use Illuminate\Http\Resources\Json\JsonResource;

class FeatureRepository
{
    public function __construct(private MaxReachedService $maxReachedService)
    {
        $this->maxReachedService = $maxReachedService;
    }

    public function store()
    {
        // $usersCount = 51;//User::query()->count();
        $maxUsers = $this->maxReachedService->canCreateNewRecord('leads_management', 99);
        // if ($usersCount >= $maxUsers) {
        //     return JsonResource::make([
        //         'message' => 'You have reached the maximum number of records',
        //     ]);
        // }
        // return JsonResource::make([
        //     'message' => 'You are subscribed to the leads_management plan, you can create ' . $usersCount . ' records',
        // ]);
    }
}
