<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CropMonitoringController extends Controller
{
    public function cropMonitoring (Request $request)
    {
        return view('user/cropMonitoring');
    }
}
