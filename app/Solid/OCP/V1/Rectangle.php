<?php

namespace App\Solid\OCP\V1;

use App\Solid\OCP\V1\Interfaces\ShapeInterface;

class Rectangle implements ShapeInterface
{
    public $width;

    public $height;

    public function __construct($width, $height)
    {
        $this->width = $width;
        $this->height = $height;
    }

    public function area(): float
    {
        return $this->width * $this->height;
    }
}
