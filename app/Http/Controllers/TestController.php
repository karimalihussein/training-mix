<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Twilio\Rest\Client;

class TestController extends Controller
{
    public function index()
    {
        $client = new Client(env('TWILIO_SID'), env('TWILIO_TOKEN'));
        $message = $client->messages->create("+201014954727", [
            'body' => 'Hello from Twilio!',
            'messagingServiceSid' => env('TWILIO_MESSAGING_SERVICE_SID')
        ]);
        dd($message);
    }
}
