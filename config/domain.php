<?php

return [
    'name' => env('ENV_NAME'),

    'names' => [
        'default' => env('DEFAULT_ENV_NAME'),
        'envA' => env('ENV_NAME_A'),
    ],

    'app' => [
        'name' => env('APP_NAME'),
        'debug' => env('APP_DEBUG'),
        'url' => env('APP_URL'),
    ],
];