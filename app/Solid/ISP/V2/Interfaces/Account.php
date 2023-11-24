<?php

declare(strict_types=1);

namespace App\Solid\ISP\V2\Interfaces;

interface Account
{
    public function changePassword($oldPassword, $newPassword);

    public function updateBilling($billingInfo);

    public function updatePlan($plan);
}
