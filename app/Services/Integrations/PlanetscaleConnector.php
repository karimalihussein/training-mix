<?php

declare(strict_types=1);
 
namespace App\Services\Integrations;
 
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
 
final readonly class PlanetscaleConnector
{
    public function __construct(private PendingRequest $request) {}
 
    public static function register(Application $app): void
    {
        $app->bind(
            abstract: PlanetscaleConnector::class,
            concrete: fn () => new PlanetscaleConnector(
                request: Http::baseUrl(
                    url: config('services.planetscale.url'),
                )->timeout(
                    seconds: 15,
                )->withHeaders(
                    headers: [
                'Authorization' => config('services.planetscale.id') . ':' . config('services.planetscale.token'),
            ],
                )->asJson()->acceptJson(),
            ),
        );
    }
}