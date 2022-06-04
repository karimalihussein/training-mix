<?php

namespace App\Http\Controllers\Tenant\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\TenantRequest;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RegisterTenantController extends Controller
{
    public function __invoke(TenantRequest $request)
    {
        $tenant = $request->store();
        return response()->json([
            'message' => 'Tenant created successfully',
        ], Response::HTTP_CREATED);
    }
}
