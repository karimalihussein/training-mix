<?php

namespace App\Query;

use Illuminate\Database\Eloquent\Model;

class EloquentORM
{

    public function __construct(private $class)
    {
        $class = $this->class;
    }


    public function query(array $relation, $conditionType, $condition, $value,  $tail = 'get')
    {
        return $this->class::query()->with($relation)->$conditionType($condition, $value)->$tail();
    }




}