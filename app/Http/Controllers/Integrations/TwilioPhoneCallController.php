<?php

namespace App\Http\Controllers\Integrations;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Twilio\Rest\Client;

class TwilioPhoneCallController extends Controller
{
    public function index()
    {
        // $url = "https://api.twilio.com/2010-04-01/Accounts/ACca3868deea5312f5a0fd2cdbd8893322/Calls.json";

        // $accountSID = 'ACca3868deea5312f5a0fd2cdbd8893322';
        // $authToken = 'a1fe45c322126d8fc5217bf331d4939d';


        // $response = Http::withHeaders([
        //     'Accept' => 'application/json',
        //     'Content-Type' => 'application/json',
        //     'Authorization' => 'Basic ' . base64_encode($accountSID . ':' . $authToken),
        // ])->get($url);

        // return $response->json();


        $account_sid = 'ACca3868deea5312f5a0fd2cdbd8893322';
        $auth_token = 'a1fe45c322126d8fc5217bf331d4939d';
        // In production, these should be environment variables. E.g.:
        // $auth_token = $_ENV["TWILIO_ACCOUNT_SID"]

        // A Twilio number you own with Voice capabilities
        $twilio_number = "+19897873731";
        $to_number = "+201014954727";


        $client = new Client($account_sid, $auth_token);

        $client->calls->create(
            // Where to send a text message (your cell phone?)
            $to_number,
            $twilio_number,
            array(
                "url" => "http://demo.twilio.com/docs/voice.xml"
            )
        );




    }
}
