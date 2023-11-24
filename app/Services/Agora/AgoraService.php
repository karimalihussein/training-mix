<?php

declare(strict_types=1);

namespace App\Services\Agora;

use DateTime;
use DateTimeZone;
use App\Classes\Agora\RtcTokenBuilder;
use App\Traits\ResponseApiTrait;

class AgoraService
{
    use ResponseApiTrait;

    public function createSdkToken($role, $data = [])
    {
    }

    public function getToken($request)
    {
        $appID = config('services.agora.ak');
        $appCertificate = config("services.agora.sk");
        $channelName = $request->channel ?? "test";
        $uid =  (int) (auth()->check() ? auth()->id() : $request->uid);

        $uidStr = (string)$uid;
        $role = $request->role ?? RtcTokenBuilder::RoleAttendee;
        // $expireTimeInSeconds = 3600*4;
        // $currentTimestamp = (new DateTime("now", new DateTimeZone('UTC')))->getTimestamp();
        // $privilegeExpiredTs = $currentTimestamp + $expireTimeInSeconds;
        $privilegeExpiredTs = now()->getTimestamp() + (3600);
        $token = RtcTokenBuilder::buildTokenWithUid($appID, $appCertificate, $channelName, $uid, $role, $privilegeExpiredTs);

        return $token;
    }
}
