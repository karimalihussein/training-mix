<?php

namespace App\Solid\V1;

use App\Solid\V1\Interfaces\ShapeInterface;

class Triangle Implements ShapeInterface
{
    public $base;
    public $height;

    public function __construct($base, $height)
    {
        $this->base = $base;
        $this->height = $height;
    }

    public function area(): float
    {
        return $this->base * $this->height / 2;
    }
 
}