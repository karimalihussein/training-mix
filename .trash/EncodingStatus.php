<?php

namespace App\Enums;



enum EncodingStatus: int
{
    case FAILURE = 1;

    case SUCCESS = 2;

    case WAITTING = 3;

    public function color(): string
    {
        return match($this)
        {
            self::FAILURE   => 'RED',
            self::SUCCESS   => 'GREEN',
            self::WAITTING  => 'YELLOW',
        };
    }
}


enum VisibilityStatus: int
{
    case PRIVATE = 1;

    case PUBLIC  = 2;

    public function color(): string
    {
        return match($this)
        {
            self::PUBLIC => 'GREEN',
            self::PRIVATE => 'RED'
        };
    }
}



var_dump(visibilityStatus::PRIVATE->color());