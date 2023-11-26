<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\MessageResource;
use App\Http\Responses\V1\ApiResponse;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\JsonResponse;

final class MessagesController
{
    public function index()
    {
        return new ApiResponse(
            data: [
                'message' => 'Service is running',
            ],
        );
    }
}
