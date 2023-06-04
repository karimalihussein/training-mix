<?php

namespace App\Http\Controllers\Integrations\Calls\Agora;

use App\Models\User;
use Illuminate\Http\Request;
use App\Events\MakeAgoraCall;
use App\Http\Controllers\Controller;
use App\Services\Agora\AgoraService;
use App\Classes\Agora\RtcTokenBuilder;

class AgoraController extends Controller
{
    public function __construct(private AgoraService $agoraService)
    {
        $this->agoraService = $agoraService;
    }

    public function createSdkToken(Request $request)
    {
        return $this->agoraService->responseData(["token" =>$this->agoraService->getToken($request)]);
    }
}
