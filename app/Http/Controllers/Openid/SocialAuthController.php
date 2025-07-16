<?php

namespace App\Http\Controllers\Openid;

use App\Enums\SocialProviderEnum;
use App\Http\Controllers\Controller;
use App\Services\Openid\SocialAuthService;

class SocialAuthController extends Controller
{
    public function __construct(private readonly SocialAuthService $socialAuthService) {}

    public function redirect(string $provider)
    {
        $providerEnum = SocialProviderEnum::tryFrom($provider);
        if (!$providerEnum) {
            abort(404, 'Provider not supported');
        }

        return $this->socialAuthService->redirectToProvider($providerEnum);
    }

    public function callback(string $provider)
    {
        $providerEnum = SocialProviderEnum::tryFrom($provider);
        if (!$providerEnum) {
            abort(404, 'Provider not supported');
        }

        return $this->socialAuthService->handleProviderCallback($providerEnum);
    }
}