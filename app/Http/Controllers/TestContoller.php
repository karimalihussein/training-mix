<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Solid\V1\Circle;
use App\Solid\V1\Triangle;
use App\Solid\V1\Rectangle;
use App\Solid\V3\PdfExport;
use App\Solid\V3\HtmlExport;
use App\Solid\V1\AreaCalculator;
use App\Solid\V2\PaymentService;
use App\Solid\V3\PostReportService;
use App\Http\Controllers\Controller;
use App\Query\EloquentORM;
use App\Solid\V2\StripePaymentMethod;
use Spatie\QueryBuilder\QueryBuilder;
use App\QueryBuilder\QueryBuilderServices;

class TestContoller extends Controller
{
    public function __invoke()
    {
        
    }
}
