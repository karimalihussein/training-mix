<?php

namespace App\Http\Controllers;

use App\Models\User;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::query()
            ->withCount('posts')
            ->get();

        return view('users.index', compact('users'));
    }
}
