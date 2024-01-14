<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Payment\Facades\Payment;
use App\Facades\Payment;

class PaymentDriverController extends Controller
{
    public function __invoke(string $driver)
    {
        if (!in_array($driver, ['paypal', 'stripe'])) {
            return response()->json(['message' => 'invalid driver'], 422);
        }

        return Payment::driver($driver)->pay(100);
    }
}
