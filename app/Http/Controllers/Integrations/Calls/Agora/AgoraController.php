<?php

declare(strict_types=1);

namespace App\Http\Controllers\Integrations\Calls\Agora;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Agora\AgoraService;

class AgoraController extends Controller
{
    public function __construct(private AgoraService $agoraService)
    {
        $this->agoraService = $agoraService;
    }

    public function createSdkToken(Request $request)
    {
        return $this->agoraService->responseData(["token" => $this->agoraService->getToken($request)]);
    }
}
