<?php

namespace App\Http\Controllers;

use App\DTOs\UserDTO;
use Illuminate\Support\Facades\Redis;
use WendellAdriel\ValidatedDTO\Exceptions\CastTargetException;
use WendellAdriel\ValidatedDTO\Exceptions\MissingCastTypeException;

class TestController extends PaymentController
{

    public function __invoke()
    {
        return $this->pay();
    }
}
