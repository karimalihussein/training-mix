<?php

namespace App\Http\Controllers;

use App\DataStructure\Fibonacci;
use App\DataStructure\Mix;

class TestController extends Controller
{

    public function __invoke()
    {
        $mixAlgorithm = new Mix();
        $target = "F";
        $array = ["A", "B", "C", "D", "E", "F", "G", "H", "I"];
        $result = $mixAlgorithm->binarySearch($array, $target);
        return $result;
    }
}
