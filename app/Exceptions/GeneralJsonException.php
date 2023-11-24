<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

class GeneralJsonException extends Exception
{
    public function render($request)
    {
        return response()->json([
            'message' => $this->getMessage(),
        ], $this->getCode());
    }

    public function report()
    {
        // Log the exception...
    }
}
