<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class YieldMonitoringController extends Controller
{
    public function yieldMonitoring()
    {
        return view('user/yieldMonitoring');
    }
}
