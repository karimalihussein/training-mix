<?php

namespace App\Enums;

enum SocialProviderEnum: string
{
    case GOOGLE = 'google';
    case GITHUB = 'github';
    case FACEBOOK = 'facebook';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}