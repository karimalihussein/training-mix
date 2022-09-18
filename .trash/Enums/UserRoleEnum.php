<?php


namespace App\Enum;

enum UserRoleEnum : string
{
    case ADMIN       = 'admin';
    case VISITOR     = 'visitor';
    case EDITOR      = 'editor';
}