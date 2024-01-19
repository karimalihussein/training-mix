<?php

declare(strict_types=1);

namespace App\Connectors;


class ForgeConnector
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
