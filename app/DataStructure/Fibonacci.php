<?php

declare(strict_types=1);

namespace App\DataStructure;

class Fibonacci
{
    public function fibonacci($number): int
    {
        if ($number == 0) {
            return 0;
        }

        if ($number == 1 || $number == 2) {
            return 1;
        }

        return $this->fibonacci($number - 1) + $this->fibonacci($number - 2);
        // time complexity: O(2^n)
        // space complexity: O(n)
    }

    public function fibonacciDynamic($number): int
    {
        $f = [];
        $f[0] = 0;
        $f[1] = 1;

        for ($i = 2; $i <= $number; $i++) {
            $f[$i] = $f[$i - 1] + $f[$i - 2];
        }

        return $f[$number];
        // time complexity: O(n)
        // space complexity: O(n)
    }

    public function fibonacciSpaceOptimized($number): int
    {
        $a = 0;
        $b = 1;
        $c = 0;

        if ($number == 0) {
            return $a;
        }

        for ($i = 2; $i <= $number; $i++) {
            $c = $a + $b;
            $a = $b;
            $b = $c;
        }

        return $b;
        // time complexity: O(n)
        // space complexity: O(1)
    }

    public function fibonacciMatrix($number): int
    {
        $f = [];
        $f[0] = 0;
        $f[1] = 1;

        $m = [[1, 1], [1, 0]];

        for ($i = 2; $i <= $number; $i++) {
            $f[$i] = $f[$i - 1] + $f[$i - 2];
        }

        return $f[$number];
        // time complexity: O(n)
        // space complexity: O(n)
    }



}
