<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoriesServiesProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(
            'App\Repositories\RepositoryInterface',
            'App\Repositories\CustomerRepository',
            'App\Repositories\PostRepository'
        );
    }
}
