<?php

namespace App\Http\Controllers;

use App\Connectors\ForgeConnector;
use App\Models\GeneralSettings;
use App\Models\Office;
use App\Models\Person;
use App\Models\Post;
use App\Models\User;
use App\Notifications\OfficePendingApproval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use GenderApi\Client as GenderApiClient;
use GrahamCampbell\ResultType\Success;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use ParagonIE\Sodium\Core\Curve25519\H;
use Meilisearch\Client;
use Nafezly\Payments\Classes\PaymobPayment;
use Omnipay\Omnipay;
use Location\Coordinate;
use Location\Distance\Vincenty;
use Location\Formatter\Coordinate\DecimalDegrees;
use Location\Formatter\Coordinate\DMS;

class TestContoller extends Controller
{
    public function __invoke()
    {
     
    }
}
