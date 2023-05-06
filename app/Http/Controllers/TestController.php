<?php

namespace App\Http\Controllers;

use App\DTOs\UserDTO;
use Illuminate\Support\Facades\Redis;
use WendellAdriel\ValidatedDTO\Exceptions\CastTargetException;
use WendellAdriel\ValidatedDTO\Exceptions\MissingCastTypeException;

class TestController extends Controller
{
    /**
     * @throws CastTargetException
     * @throws MissingCastTypeException
     */
    public function __invoke()
    {
//      $counter = Redis::incr('counter');
//      return $counter;

        $data =  new UserDTO([
            'email' => 'john.doe@example.com',
            'password' => 's3CreT!@1a2B'
        ]);
        return $data->name;
    }
}
