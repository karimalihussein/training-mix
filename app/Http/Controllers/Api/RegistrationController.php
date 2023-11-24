<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function __invoke(Request $request)
    {
        // validate the request....
        $this->validate($request, [
            'type' => 'required|string|in:user,admin,super_admin',
        ]);
        // register the user...
        return $this->registrationStrategy($request->type);
    }

    protected function registrationStrategy(string $type)
    {
        return match ($type) {
            'user' => response()->json(['message' => 'User registered successfully']),
            'admin' => response()->json(['message' => 'Admin registered successfully']),
            'super_admin' => response()->json(['message' => 'Super Admin registered successfully']),
            default => response()->json(['message' => 'Invalid registration type']),
        };
    }
}
