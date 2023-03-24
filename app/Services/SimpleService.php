<?php

namespace App\Services;

class SimpleService
{
    public function log($string)
    {
        logger($string);
    }
}