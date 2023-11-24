<?php

declare(strict_types=1);

namespace App;

class Postcard
{
    protected static function resolveFacade($name)
    {
        return app()[$name];
    }

    public static function __callStatic($method, $arguments)
    {
        return self::resolveFacade('Postcard')->$method(...$arguments);
    }
}
