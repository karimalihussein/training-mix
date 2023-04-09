<?php

namespace App\Http\Controllers;

use App\Solid\V1\Circle;
use App\Solid\V1\Triangle;
use App\Solid\V1\Rectangle;
use App\Solid\V1\AreaCalculator;
use App\Solid\V2\PaymentService;
use App\Http\Controllers\Controller;
use App\Solid\V2\StripePaymentMethod;

class TestContoller extends Controller
{
    public function __invoke()
    {
        // $shapes = [
        //     new Rectangle(2, 3),
        //     new Circle(4),
        //     new Triangle(4, 5)
        // ];
        // return (new AreaCalculator)->calculate(...$shapes);

        return (new PaymentService)->pay(new StripePaymentMethod);
    }
}
