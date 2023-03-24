<?php

namespace App\Connectors;

use Saloon\Http\Connector;

class ForgeConnector extends Connector
{
    public function resolveBaseUrl(): string
    {
        return 'https://api.publicapis.org/entries';
    }

    protected function defaultHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }
}