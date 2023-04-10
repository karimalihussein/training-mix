<?php

namespace App\Solid\ISP\V2\interfaces;

interface Account
{
    public function changePassword($oldPassword, $newPassword);
    public function updateBilling($billingInfo);
    public function updatePlan($plan);
}

