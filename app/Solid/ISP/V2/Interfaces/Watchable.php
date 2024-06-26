<?php

declare(strict_types=1);

namespace App\Solid\ISP\V2\Interfaces;

interface Watchable
{
    public function viewWatchlist();

    public function viewHistory();

    public function viewRecommendations();
}
