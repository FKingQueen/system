<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Municipality;
use App\Models\Farmer;
use App\Models\Farming_data;
use App\Models\Activity_file;
use DateTime;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class YieldMonitoringController extends Controller
{
    public function yieldMonitoring(Request $request)
    {
        
        $data1 = Farming_data::with('crop' , 'cropping_season')->whereYear('created_at', '=', $request->year_id)
        ->where('municipality_id',  $request->municipality)
        ->where('barangay_id',  $request->barangay)
        ->where('crop_id',  $request->crop_id)
        ->where('status_id',  2)
        ->where('cropping_season_id',  $request->cropping_season)->orderBy('yield', 'desc')->get();

        $auth= Farming_data::whereYear('created_at', '=', $request->year_id)
        ->where('municipality_id',  $request->municipality)
        ->where('barangay_id',  $request->barangay)
        ->where('crop_id',  $request->crop_id)
        ->where('status_id',  2)
        ->where('cropping_season_id',  $request->cropping_season)->orderBy('yield', 'desc')->count();

        if($auth == 0)
        {
            return back()->with('failed', 'Update Sucessfully');
        }


        foreach($data1 as $key => $data)
        {
            $farmerName[$key] =  farmer::where('id' , $data->farmer_id)->value('name');
        }

        foreach($data1 as $key => $data)
        {
            $farmerId[$key] =  $data->farmer_id;
        }

        foreach($data1 as $key => $data)
        {
            $farmingId[$key] =  $data->id;
        }


        foreach($data1 as $key => $data)
        {
            $total = Activity_file::where('farming_data_id',$farmingId[$key])->where('farmer_id',$farmerId[$key])->where('status_id', '2')->count();
            for($i = 0; $i <= 2; $i++)
            {
                if($i == 0)
                {
                    $activity[$key][$i] =  number_format((Activity_file::where('farming_data_id',$farmingId[$key])->where('farmer_id',$farmerId[$key])->where('activity', 'water')->where('status_id', '2')->count() / $total) *100);
                } else if($i == 1)
                {
                    $activity[$key][$i] = number_format((Activity_file::where('farming_data_id',$farmingId[$key])->where('farmer_id',$farmerId[$key])->where('activity', 'fertilizer')->where('status_id', '2')->count() / $total) *100);
                } else if($i == 2)
                {
                    $activity[$key][$i] = number_format((Activity_file::where('farming_data_id',$farmingId[$key])->where('farmer_id',$farmerId[$key])->where('activity', 'pesticide')->where('status_id', '2')->count() / $total) *100);
                }
               
            }
        }

        foreach($data1 as $key => $data)
        {
           
            for($i = 0; $i <= 2; $i++)
            {
                if($i == 0)
                {
                    $activityC[$key][$i] = Activity_file::where('farming_data_id',$farmingId[$key])->where('farmer_id',$farmerId[$key])->where('activity', 'water')->where('status_id', '2')->count();
                } else if($i == 1)
                {
                    $activityC[$key][$i] = Activity_file::where('farming_data_id',$farmingId[$key])->where('farmer_id',$farmerId[$key])->where('activity', 'fertilizer')->where('status_id', '2')->count();
                } else if($i == 2)
                {
                    $activityC[$key][$i] = Activity_file::where('farming_data_id',$farmingId[$key])->where('farmer_id',$farmerId[$key])->where('activity', 'pesticide')->where('status_id', '2')->count();
                }
               
            }
        }

        foreach($data1 as $key => $data)
        {
            $firstdate = Activity_file::where('farming_data_id',$farmingId[$key])->where('farmer_id',$farmerId[$key])->where('status_id', '2')->first();
            $latestdate = Activity_file::where('farming_data_id',$farmingId[$key])->where('farmer_id',$farmerId[$key])->where('status_id', '2')->latest('created_at')->first();
            
            $firstdate = $firstdate->created_at;            
            $latestdate = $latestdate->created_at;            
            
            $firstdate = new DateTime($firstdate);
            $latestdate = new DateTime($latestdate);
            
            
            $interval = $firstdate->diff($latestdate);
            $d = $interval->format('%a');//now do whatever you like with $days

            $days[$key] = $d;
        }

        foreach($data1 as $key => $data)
        {
            $firstmonth = Activity_file::where('farming_data_id',$farmingId[$key])->where('farmer_id',$farmerId[$key])->where('status_id', '2')->first();
            $latestmonth = Activity_file::where('farming_data_id',$farmingId[$key])->where('farmer_id',$farmerId[$key])->where('status_id', '2')->latest('created_at')->first();
            
            $firstmonth = $firstmonth->created_at;            
            $latestmonth = $latestmonth->created_at;  

            $firstmonth = new DateTime($firstmonth);
            $latestmonth = new DateTime($latestmonth);

            $fmonth[$key] = $firstmonth->format('F');
            $lmonth[$key] = $latestmonth->format('F');
        }

        $municipality = DB::table("municipalities")->pluck("name","id");
        return view('user/yieldMonitoring', array("municipalities" => $municipality, "data1s" => $data1, "farmerName" => $farmerName, "activity" => $activity, "activityC" => $activityC, "days" => $days, "fmonth" => $fmonth, "lmonth" => $lmonth));
    }
}
