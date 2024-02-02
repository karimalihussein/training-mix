<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Support\Data\PostData;

final class PostController extends Controller
{
    public function store(PostData $data): Post
    {
        return Post::create($data->toArray());
    }
}