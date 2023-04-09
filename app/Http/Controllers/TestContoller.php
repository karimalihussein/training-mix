<?php

namespace App\Http\Controllers;

use App\Solid\V1\Circle;
use App\Solid\V1\Triangle;
use App\Solid\V1\Rectangle;
use App\Solid\V1\AreaCalculator;
use App\Solid\V2\PaymentService;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Solid\V2\StripePaymentMethod;
use App\Solid\V3\HtmlExport;
use App\Solid\V3\PdfExport;
use App\Solid\V3\PostReportService;

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

        // return (new PaymentService)->pay(new StripePaymentMethod);

        // Post::factory()->count(10)->create([
        //     'created_at' => now()->subDays(5)
        // ]);

        // return (new PostReportService)->between(now()->subDays(10), now()->subDays(5))->export(
        //     new PdfExport
        // );
    }
}
