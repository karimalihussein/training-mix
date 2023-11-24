<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\AchievementRequest;
use Symfony\Component\HttpFoundation\Response;

class AchievementController extends Controller
{
    public function store(AchievementRequest $request)
    {
        return response($request->store(), Response::HTTP_CREATED);
    }
}
