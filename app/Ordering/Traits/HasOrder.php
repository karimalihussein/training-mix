<?php

declare(strict_types=1);

namespace App\Ordering\Traits;

use App\Ordering\Orderer;

trait HasOrder
{
    public function ordering()
    {
        return new Orderer($this);
    }
}
