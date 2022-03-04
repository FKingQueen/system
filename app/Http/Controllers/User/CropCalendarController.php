<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Farming_data;
use App\Models\Crop;
use App\Models\Barangay;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CropCalendarController extends Controller
{
    public function cropCalendar ()
    {
        $crop = Crop::all();
        $date = Carbon::now();
        $brgy = Barangay::where('municipality_id','1')->get();

        for($i = 4; $i >= 0; $i--)
        {
            $year[$i] = $date->year - $i;
        }

        for($i = 4; $i >= 0; $i--)
        {

            for($j = 0; $j <= Crop::count()-1; $j++)
            {
                $total = Farming_data::whereYear('created_at', '=', $year[$i])->count();

                for($k = 0; $k <= Crop::count()-1; $k++)
                {
                    if($total!=0)
                    {
                        $percentage[$i][$k] = number_format((Farming_data::whereYear('created_at', '=', $year[$i])->where('crop_id', $k+1)->count() / $total)*100, 0);
                    }
                    else {
                        $percentage[$i][$k] = 0;
                    }
                }
            }
            
            $total=0;
        }



        return view('user/cropCalendar', array("years"=> $year,"percentages"=> $percentage,"crops" => $crop, "brgys" => $brgy));
    }
}
