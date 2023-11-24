<?php

declare(strict_types=1);

namespace App\Query;

use Illuminate\Support\Facades\DB;

class QueryBuilderServices
{
    public function data()
    {
        $data = DB::table('posts')->pluck('title');

        return $data;
    }

    /**
     * insert
     * insertOrIgnore
     * sum
     * avg
     * max
     * min
     * where
     * whereIn
     * whereNotIn
     * whereBetween
     * whereNotBetween
     * whereNull
     * whereNotNull
     * whereDate
     * whereMonth
     * whereDay
     * whereYear
     * whereTime
     * whereColumn
     * whereRaw
     * whereExists
     * whereNotExists
     * whereJsonContains
     * whereJsonDoesntContain
     * whereJsonLength
     */
    public function query($conditionType, $condition, $value)
    {
        $data = DB::table('posts')->$conditionType($condition, $value)->get();

        return $data;
    }
}
