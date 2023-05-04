<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Process\Process;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('tail {file=storage/logs/laravel.log} {--only=}', function () {
    $command = 'tail -f "$FILE" | grep "$ONLY"';
    Process::fromShellCommandline($command)
        ->setTty(true)
        ->setTimeout(null)
        ->run(null, [
            'FILE' => $this->argument('file'),
            'ONLY' => $this->option('only'),
        ]);
})->purpose('Tail a file');
