<?php

declare(strict_types=1);

namespace App\Models;

use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{
    public string $site_name;

    public bool $site_active;

    public static function group(): string
    {
        return 'general';
    }
}
