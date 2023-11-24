<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\TagResource;

class TagController extends Controller
{
    public function __invoke()
    {
        return TagResource::collection(
            \App\Models\Tag::all()
        );
    }
}
