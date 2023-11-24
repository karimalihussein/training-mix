<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Validation\ValidationException;

trait ResponseApiTrait
{
    /**
     * Throw validation exception.
     *
     * @param string $message
     * @param string $key
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function throwValidationException(string $message, string $key = "message"): void
    {
        throw ValidationException::withMessages([$key => $message]);
    }

    /**
     * Reponse Resource function
     *
     * @param mixed $resource
     * @param array|null $additional
     * @param integer $status
     * @return mixed
     */
    public function responseResource(object $resource, array $additional = null, $status = 200)
    {
        if ($additional) {
            $resource->additional($additional);
        }
        return $resource->response()
               ->setStatusCode($status);
    }

    /**
     * Reponse Normal array
     *
     * @param array $data
     * @param integer $status
     * @return mixed
     */
    public function responseData(array $data = null, int $status = 200)
    {
        return response()->json($data, $status);
    }
}
