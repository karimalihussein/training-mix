<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::query()
            ->withLastLogin()
            ->orderBy('name')
            ->get();

        return $users;
    }
}
