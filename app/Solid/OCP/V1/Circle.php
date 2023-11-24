<?php

declare(strict_types=1);

namespace App\Solid\OCP\V1;

use App\Solid\OCP\V1\Interfaces\ShapeInterface;

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
