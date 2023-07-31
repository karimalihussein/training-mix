<?php

// namespace App\Problemes;

// class BearandBigBrother
// {
//     public function __construct(private int $limakWeight, private int $bobWeight)
//     {
//         $this->limakWeight = $limakWeight;
//         $this->bobWeight = $bobWeight;
//     }

//     public function getYears(): int
//     {
//         $years = 0;
//         while ($this->limakWeight <= $this->bobWeight) {
//             $this->limakWeight *= 3;
//             $this->bobWeight *= 2;
//             $years++;
//         }
//         return $years;
//     }
// }

function getYears($limakWeight, $bobWeight): int
{
    $years = 0;
    while ($limakWeight <= $bobWeight) {
        $limakWeight *= 3;
        $bobWeight *= 2;
        $years++;
    }
    return (string) $years;
}


