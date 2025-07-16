<?php

namespace App\Services\Openid;

use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use App\Models\SocialAccount;
use Illuminate\Support\Facades\Auth;
use App\Enums\SocialProvider;
use App\Enums\SocialProviderEnum;

class SocialAuthService
{
    public function validateProvider(SocialProviderEnum $provider): void
    {
        if (!in_array($provider->value, SocialProviderEnum::values())) {
            throw new \Exception('Provider not supported');
        }
    }

    public function redirectToProvider(SocialProviderEnum $provider)
    {
        return Socialite::driver($provider->value)->redirect();
    }

    public function handleProviderCallback(SocialProviderEnum $provider)
    {
        $socialUser = Socialite::driver($provider->value)->stateless()->user();

        $user = $this->findOrCreateUser($socialUser, $provider);

        Auth::login($user);

        return redirect('/dashboard');
    }

    protected function findOrCreateUser($socialUser, SocialProviderEnum $provider)
    {
        $socialAccount = SocialAccount::where('provider_name', $provider->value)
            ->where('provider_id', $socialUser->getId())
            ->first();

        if ($socialAccount) {
            return $socialAccount->user;
        }

        $user = User::where('email', $socialUser->getEmail())->first();

        if (!$user) {
            $user = User::create([
                'name' => $socialUser->getName(),
                'email' => $socialUser->getEmail(),
                'email_verified_at' => now(),
            ]);
        }

        $user->socialAccounts()->create([
            'provider_name' => $provider->value,
            'provider_id'   => $socialUser->getId(),
            'access_token'  => $socialUser->token,
            'refresh_token' => $socialUser->refreshToken ?? null,
        ]);

        return $user;
    }
}