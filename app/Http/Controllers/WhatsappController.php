<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WhatsappController extends Controller
{
    public function index()
    {
        // Instantiate the WhatsAppCloudApi super class.
            $whatsapp_cloud_api = new WhatsAppCloudApi([
                'from_phone_number_id' => '+01014954727',
                'access_token' => 'your-facebook-whatsapp-application-token',
            ]);
            $whatsapp_cloud_api->sendTextMessage('+01069709652', 'Hey there! I\'m using WhatsApp Cloud API. Visit https://www.netflie.es');

    }
}
