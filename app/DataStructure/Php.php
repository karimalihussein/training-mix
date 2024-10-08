<?php

declare(strict_types=1);

namespace App\DataStructure;

class Php
{
    public function filter(array $items, $fn): array
    {
        $filter = [];
        foreach ($items as $item) {
            if ($fn($item)) {
                $filter[] = $item;
            }
        }
        return $filter;
    }


}
