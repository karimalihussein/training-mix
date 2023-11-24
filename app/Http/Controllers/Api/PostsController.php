<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Models\Post;
use Orion\Http\Controllers\Controller;

class PostsController extends Controller
{
    use \Orion\Concerns\DisableAuthorization;

    protected $model = Post::class;
}
