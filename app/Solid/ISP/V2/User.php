<?php

namespace App\Solid\ISP\V2;

use App\Solid\ISP\V2\Interfaces\Account;
use App\Solid\ISP\V2\Interfaces\Watchable;

class User implements Watchable, Account
{
    public function viewWatchlist()
    {
        // View watchlist
    }

    public function viewHistory()
    {
        // View history
    }

    public function viewRecommendations()
    {
        // View recommendations
    }

    public function changePassword($oldPassword, $newPassword)
    {
        // Change password
    }

    public function updateBilling($billingInfo)
    {
        // Update billing
    }

    public function updatePlan($plan)
    {
        // Update plan
    }
}
