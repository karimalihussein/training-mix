<?php

declare(strict_types=1);

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class PlanUnauthorizedException extends HttpException
{
    private $requiredFeatures = [];

    public static function forFeatures(array $permissions): self
    {
        $message = 'Company does not have the right permissions.';

        $exception = new static(403, $message, null, []);
        $exception->requiredFeatures = $permissions;

        return $exception;
    }

    public static function notLoggedIn(): self
    {
        return new static(403, 'User is not logged in.', null, []);
    }

    public function getRequiredRoles(): array
    {
        return $this->requiredRoles;
    }

    public function getRequiredPermissions(): array
    {
        return $this->requiredPermissions;
    }
}
