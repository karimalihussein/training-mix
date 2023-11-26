<?php

declare(strict_types=1);

use App\Http\Controllers\Api\V1\MessagesController;
use Illuminate\Http\Response;
use Illuminate\Testing\TestResponse;

it('returns the correct status code', function (): void {
    $controller = new MessagesController();
    $response = $controller->index();
    expect($response)->toBeInstanceOf(\App\Http\Responses\V1\ApiResponse::class);
});
