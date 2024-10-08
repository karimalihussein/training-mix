<?php

namespace Modules\Payment\Exceptions;

use RuntimeException;

final class PaymentFailedException extends RuntimeException
{
    public static function dueToInvalidToken(): self
    {
        return new self('The given payment token is invalid.');
    }
}