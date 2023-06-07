<?php

namespace App\DataStructure;

class Node
{
    public $value;
    public $next;

    public function __construct($value)
    {
        $this->value = $value;
        $this->next  = null;
    }

    public function __toString()
    {
        return (string) $this->value;
    }

    public function __debugInfo()
    {
        return [
            'value' => $this->value,
            'next'  => $this->next,
        ];
    }

    public function __invoke()
    {
        return $this->value;
    }






}
