<?php

namespace App\Http\Responses\Concerns;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use JustSteveKing\StatusCode\Http;

trait ReturnsJsonResponse
{

    /**
     * @param array<string, mixed> $data
     * @param Http $status
     */
    public function __construct(
        private array $data,
        private Http $status = Http::OK,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     * @param int $status
     */
    public function toResponse($request): JsonResponse
    {
        return new JsonResponse(
            data: $this->data,
            status: $this->status->value,
        );
    }
}
