<?php

namespace App\Support\Data;

use App\Enums\PostActiveEnum;
use Spatie\LaravelData\Data;

final class PostData extends Data
{
    public function __construct(
        public string $title,
        public string $content,
        public PostActiveEnum $active,
    ) {
    }
}