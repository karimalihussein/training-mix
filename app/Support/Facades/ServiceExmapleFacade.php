<?php 

namespace App\Support\Facades;

use Illuminate\Support\Facades\Facade;

class ServiceExampleFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'serviceExample';
    }
}