<?php

$data = [
    'entityId' => '8ac7a4c8805fe6cc0180600c9d850020',
    'amount' => 01.00,
    'currency' => 'SAR',
    'paymentType' => 'DB',
    'customer.surname' => 'Doe',
    'customer.givenName' => 'Jane',
    'customer.email' => 'test@gmail.com',
    'customer.ip' => '123.1.4.67.0',
    'customer.birthday' => '1970-01-01',
    'customer.phone' => '+31612345678',
    'billing.city' => 'Amsterdam',
    'billing.country' => 'NL',
    'billing.street1' => 'Keizersgracht 313',
    'billing.postcode' => '1118CB',
    'billing.postcode' => '1118CB',
];

$url = 'https://eu-test.oppwa.com/v1/checkouts';




$response = Http::withToken('OGFjN2E0Yzg4MDVmZTZjYzAxODA2MDBjMWZlYjAwMWN8UWIyQzVOZWd3QQ')->post($url, $data);
$response = $response->json();
return $response;