<?php

declare(strict_types=1);

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;
use TiMacDonald\JsonApi\JsonApiResource;


/**
 * @property-read string $message
 */
final class MessageResource extends JsonResource
{
    public function toArray(\Illuminate\Http\Request $request): array
    {
        return [
            'message' => $this->resource['message'],
        ];
    }
}