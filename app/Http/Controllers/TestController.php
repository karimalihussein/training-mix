<?php

namespace App\Http\Controllers;

use App\Models\User;
use Rmunate\Utilities\SpellNumber;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Services\Integrations\Twitter\TwitterService;
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
