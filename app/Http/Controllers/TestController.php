<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Laravel\Passport\Bridge\AccessTokenRepository;
use \League\OAuth2\Server\Entities\AccessTokenEntityInterface;

class TestController extends Controller
{
    public function __invoke()
    {
        $accessTokenRepository = new AccessTokenRepository(); // instance of AccessTokenRepositoryInterface

        // Path to authorization server's public key
        $publicKeyPath = 'file://path/to/public.key';

        // Setup the authorization server
        $server = new \League\OAuth2\Server\ResourceServer(
            $accessTokenRepository,
            $publicKeyPath
        );
    }
}
