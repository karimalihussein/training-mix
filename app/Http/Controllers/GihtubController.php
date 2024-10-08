<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GihtubController extends Controller
{
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('github')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        $user = Socialite::driver('github')->user();
        $user = User::create([
            'name' => $user->name,
            'email' => $user->email,
            'password' => Hash::make($password = Str::random(8)),
        ]);
        auth()->login($user);
        $user->notify(new \App\Notifications\WelcomeNotification($password));

        return redirect()->route('dashboard');
    }
}
