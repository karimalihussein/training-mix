<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckSyntax extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:syntax';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks the syntax of all PHP files in the project';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        (new \App\Services\CheckSyntaxService())->handle();
    }
}
