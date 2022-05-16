<?php

namespace App\Http\Controllers;

use App\Http\Requests\AchievementRequest;
use App\Models\Achievement;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AchievementController extends Controller
{
    
    public function store(AchievementRequest $request)
    {
        return response($request->store(), Response::HTTP_CREATED);
    }
}   
