<?php

namespace App\QueryFilters;
use Closure;

class Salary extends Filter
{

    protected  function applyFilter($builder)
    {
        return $builder->where('salary', '=>', 3000);
    }
}