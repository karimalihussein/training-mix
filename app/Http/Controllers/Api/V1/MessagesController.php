<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\MessageResource;
use App\Http\Responses\V1\ApiResponse;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\JsonResponse;
use App\Services\Cache\StorageService;

final class MessagesController
{

    public function __construct(private readonly StorageService $cache)
    {
    }

    public function index()
    {
        return new ApiResponse(
            data: [
                'message' => 'Service is running',
            ],
        );
    }
}
