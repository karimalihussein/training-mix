<?php

declare(strict_types=1);

namespace App\DataStructure;

class Factorial
{
    public function factorial($number): float|int
    {
        if ($number < 0) {
            return -1;
        }

        if ($number == 0) {
            return 1;
        }
        return $number * $this->factorial($number - 1);
        // time complexity: O(n)
        // space complexity: O(n)
    }

    public function factorialLoop($number): float|int
    {
        if ($number < 0) {
            return -1;
        }

        if ($number == 0) {
            return 1;
        }

        $result = 1;
        for ($i = 1; $i <= $number; $i++) {
            $result *= $i;
        }
        return $result;
        // time complexity: O(n)
        // space complexity: O(1)
    }

    public function factorialTailRecursion($number, $accumulator = 1): float|int
    {
        if ($number < 0) {
            return -1;
        }

        if ($number == 0) {
            return $accumulator;
        }

        return $this->factorialTailRecursion($number - 1, $accumulator * $number);
        // time complexity: O(n)
        // space complexity: O(1)
    }




}
