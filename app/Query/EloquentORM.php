<?php

declare(strict_types=1);

namespace App\Query;

class EloquentORM
{
    public function __construct(private $class)
    {
        $class = $this->class;
    }

    public function query(array $relation, $conditionType, $condition, $value, $tail = 'get')
    {
        return $this->class::query()->with($relation)->$conditionType($condition, $value)->$tail();
    }
}
