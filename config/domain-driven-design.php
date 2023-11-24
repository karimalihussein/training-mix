<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Assign Namespace
    |--------------------------------------------------------------------------
    |
    |
    */

    'namespace' => 'App\\Domain',

    /*
    |--------------------------------------------------------------------------
    | Default scaffold folders of a domain
    |--------------------------------------------------------------------------
    |
    |
    */

    'scaffold_folders' => [
        '/Actions',
        '/Events',
        '/Listeners',
        '/Exceptions',
        '/Http/Controllers',
        '/Http/Middleware',
        '/Http/Requests',
        '/Http/Resources',
        '/Models',
        '/Policies',
        '/Observers',
        '/Data',
        '/Jobs',
        '/Services',
    ],

];
