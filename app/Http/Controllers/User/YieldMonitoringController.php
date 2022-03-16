<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Municipality;
use App\Models\Farming_data;
use Illuminate\Support\Facades\DB;

class YieldMonitoringController extends Controller
{
    public function yieldMonitoring(Request $request)
    {
        
        $data1 = Farming_data::whereYear('created_at', '=', $request->year_id)
        ->where('municipality_id',  $request->municipality)
        ->where('barangay_id',  $request->barangay)
        ->where('crop_id',  $request->crop_id)
        ->where('status_id',  2)
        ->where('cropping_season_id',  $request->cropping_season)->orderBy('yield', 'desc')->get();

        foreach($data1 as $key => $data)
        {
            $farmerId[$key] =  $data->farmer_id;
        }

        foreach($data1 as $key => $data)
        {
            
        }

        $municipality = DB::table("municipalities")->pluck("name","id");
        return view('user/yieldMonitoring', array("municipalities" => $municipality, "data1s" => $data1));
    }
}
