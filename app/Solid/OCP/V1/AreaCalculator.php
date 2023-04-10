<?php

namespace App\Solid\OCP\V1;

use App\Solid\OCP\V1\Interfaces\ShapeInterface;

class AreaCalculator
{
    public function calculate(ShapeInterface ...$shapes)
    {
        $area = 0;
        foreach ($shapes as $shape) {
            $area += $shape->area();
        }
        return $area;
    }
}