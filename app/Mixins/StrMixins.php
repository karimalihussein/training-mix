<?php

namespace App\Mixins;

class StrMixins
{


    public function partNumber()
    {
        return function ($value){
            return 'AB-' . substr($value, 0, 3) . '-' . substr($value,3);
        };
    }

    public function prefix()
    {
        return function($string, $prefix = 'AB-') {
            return $prefix . $string;
        };
    }
}