<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Municipality;
use Illuminate\Support\Facades\DB;

class YieldMonitoringController extends Controller
{
    public function yieldMonitoring()
    {
        $municipality = DB::table("municipalities")->pluck("name","id");
        return view('user/yieldMonitoring', array("municipalities" => $municipality));
    }
}
