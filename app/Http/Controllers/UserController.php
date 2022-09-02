<?php

namespace App\Http\Controllers;

use App\Models\Login;
use App\Models\User;
use Illuminate\Http\Request;

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
