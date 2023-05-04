<?php

use Spatie\Valuestore\Valuestore;

if (! function_exists('settings')) {
    /**
     * Gets the value from settings json file.
     *
     * @param  string  $key
     * @param  mixed  $default
     * @return mixed
     */
    function settings($key, $default = null)
    {
        $key = Valuestore::make(public_path('settings.json'))->get($key);

        return $key ?? $default;
    }
}
