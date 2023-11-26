<?php

declare(strict_types=1);

namespace App\Services\Cache;

use Illuminate\Support\Facades\Cache;
use Closure;

final class StorageService
{
    private Cache $cache;

    public function __construct(Cache $cache)
    {
        $this->cache = $cache;
    }

    public function set(string $key, Closure $closure, int $minutes = 60): bool
    {
        return $this->cache->put($key, $closure(), $minutes);
    }
}
