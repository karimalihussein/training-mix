<?php

namespace App\Services\Tenant;

use Bpuig\Subby\Models\Plan;
use Illuminate\Database\Eloquent\Model;

class MaxReachedService
{
    public function feature(string $feature): int
    {
        if(tenant()->subscription('main')->getFeatureByTag($feature)) {
            return tenant()->subscription('main')->getFeatureValue($feature);
        }
        return 0;
    }

    public function canCreateNewRecord(string $feature, int $modelCount): bool
    {
        $max = $this->feature($feature);
        return $modelCount < $max;
    }
}
