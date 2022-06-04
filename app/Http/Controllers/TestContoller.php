<?php

namespace App\Http\Controllers;

use App\Models\Office;
use App\Models\User;
use App\Notifications\OfficePendingApproval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class TestContoller extends Controller
{
    // public function sentNotification()
    // {
    //     $office = Office::factory()->create();
    //     $admin  = User::factory()->create(['is_admin' => true]);
        
    //     Notification::send($admin, new OfficePendingApproval($office));

    //     return response()->json(['message' => 'Notification sent']);
    // }

    public function __invoke()
    {


    }
}
