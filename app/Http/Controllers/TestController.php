<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\DesignPatterns\BehavioralPatterns\ChainOfResponsibility\ChainOfResponsibilityService;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function __invoke()
    {
        return (new ChainOfResponsibilityService())->run();
    }
}
