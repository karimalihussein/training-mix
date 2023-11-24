<?php

declare(strict_types=1);

namespace App\QueryFilters;

class Salary extends Filter
{
    protected function applyFilter($builder)
    {
        return $builder->where('salary', '=>', 3000);
    }
}
