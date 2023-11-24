<?php

declare(strict_types=1);

namespace App\DataStructure;

class Mix
{
    public function sorting(array $array): array
    {
        $length = count($array);
        for ($i = 0; $i < $length; $i++) {
            for ($j = $i; $j < $length; $j++) {
                if ($array[$i] > $array[$j]) {
                    $temp = $array[$j];
                    $array[$j] = $array[$i];
                    $array[$i] = $temp;
                }
            }
        }
        return $array;
        // time complexity: O(n^2)
        // space complexity: O(1)
    }

    public function mergeSort(array $array): array
    {
        $length = count($array);
        if ($length == 1) {
            return $array;
        }
        $mid = floor($length / 2);
        $left = array_slice($array, 0, $mid);
        $right = array_slice($array, $mid);
        return $this->merge($this->mergeSort($left), $this->mergeSort($right));
    }

    public function merge(array $left, array $right): array
    {
        $result = [];
        $leftLength = count($left);
        $rightLength = count($right);
        $leftIndex = 0;
        $rightIndex = 0;
        while ($leftIndex < $leftLength && $rightIndex < $rightLength) {
            if ($left[$leftIndex] < $right[$rightIndex]) {
                $result[] = $left[$leftIndex];
                $leftIndex++;
            } else {
                $result[] = $right[$rightIndex];
                $rightIndex++;
            }
        }
        while ($leftIndex < $leftLength) {
            $result[] = $left[$leftIndex];
            $leftIndex++;
        }
        while ($rightIndex < $rightLength) {
            $result[] = $right[$rightIndex];
            $rightIndex++;
        }
        return $result;
    }

    // quickSort algorithm
    public function quickSort(array $array): array
    {
        $length = count($array);
        if ($length <= 1) {
            return $array;
        }
        $pivot = $array[0];
        $left = [];
        $right = [];
        for ($i = 1; $i < $length; $i++) {
            if ($array[$i] < $pivot) {
                $left[] = $array[$i];
            } else {
                $right[] = $array[$i];
            }
        }
        return array_merge($this->quickSort($left), [$pivot], $this->quickSort($right));
    }

    // bucketSort algorithm
    public function bucketSort(array $array): array
    {
        $length = count($array);
        if ($length <= 1) {
            return $array;
        }
        $max = max($array);
        $min = min($array);
        $bucketLength = $max - $min + 1;
        $bucket = array_fill(0, $bucketLength, 0);
        for ($i = 0; $i < $length; $i++) {
            $bucket[$array[$i] - $min]++;
        }
        $result = [];
        for ($i = 0; $i < $bucketLength; $i++) {
            for ($j = 0; $j < $bucket[$i]; $j++) {
                $result[] = $i + $min;
            }
        }
        return $result;
    }

    public function binarySearch(array $array, Mixed $target): float|int
    {
        $length = count($array);
        if ($length == 0) {
            return -1;
        }
        $left = 0;
        $right = $length - 1;
        while ($left <= $right) {
            $mid = floor(($left + $right) / 2);
            if ($array[$mid] == $target) {
                return $mid;
            } elseif ($array[$mid] < $target) {
                $left = $mid + 1;
            } else {
                $right = $mid - 1;
            }
        }
        return -1;
        // time complexity: O(logn)
        // space complexity: O(1)
    }




}
