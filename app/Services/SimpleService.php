<?php

declare(strict_types=1);

namespace App\Services;

class SimpleService
{
    public function log($string)
    {
        logger($string);
    }
}
