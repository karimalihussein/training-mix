<?php

namespace App\Solid\V1;


use App\Solid\V1\Interfaces\ShapeInterface;

class Circle implements ShapeInterface
{
    public $radius;

    public function __construct($radius)
    {
        $this->radius = $radius;
    }

    public function area(): float
    {
        return $this->radius * $this->radius * pi();
    }
}