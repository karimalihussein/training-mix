<?php

namespace App\Http\Controllers;

use App\Models\GeneralSettings;
use App\Models\Office;
use App\Models\User;
use App\Notifications\OfficePendingApproval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class TestContoller extends Controller
{
    public function __invoke(GeneralSettings $settings){
        return $settings;
    }
}
