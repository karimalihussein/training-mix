<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;

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
