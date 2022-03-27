<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Farming_data;
use App\Models\Crop;
use App\Models\Farmer;
use App\Models\Barangay;
use App\Models\Municipality;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CropCalendarController extends Controller
{
    public function cropCalendar (Request $request)
    {   

        $request->validate([
            'year_id'  => 'required',
            'municipality_id'  => 'required',
        ]);



        $muni = Municipality::where('id',$request->municipality_id)->get();

        $crop = Crop::all();
        $date = Carbon::now();
        $brgy = Barangay::where('municipality_id', $request->municipality_id)->get();
        $brgycount = Barangay::where('municipality_id', $request->municipality_id)->count();
        $brgyfirst = Barangay::where('municipality_id', $request->municipality_id)->value('id');

        for($i = 4; $i >= 0; $i--)
        {
            $year[$i] = $date->year - $i;
        }

        // dd($request->year_id);

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

        if($request->year_id != null)
        {

            if($request->year_id == 0){$year_id = 4;}
            if($request->year_id == 1){$year_id = 3;}
            if($request->year_id == 2){$year_id = 2;}
            if($request->year_id == 3){$year_id = 1;}
            if($request->year_id == 4){$year_id = 0;}

            $total = Farming_data::whereYear('created_at', $year[$year_id])->where('municipality_id', $request->municipality_id)->count();
            if($total==0)
            {
                $total=1;
            }
        }

        $currentyear = $year[$year_id];

        $k=1;
        $x=$brgyfirst;
        $i = 0;
            while($i<=12*$brgycount-1)
            {
                for($p=1;$p<=12;$p++)  
                {
                    $chk = Farming_data::whereMonth('created_at', '=', $p )->whereYear('created_at', '=', $year[$year_id])->where('barangay_id', $x)->count();
                    if($chk!=0)
                    {
                        for($j = 1; $j<=Crop::count(); $j++)
                        {
                            $perc[$i][$j] = number_format((Farming_data::whereMonth('created_at', '=', $p )->whereYear('created_at', '=', $year[$year_id])->where('barangay_id', $x)->where('crop_id', $j)->count() / $total)*100,0);
                        }
                        $i++;
                    } 
                    else  {
                        $perc[$i][0
                        ] = null;
                        // $perc[$i][0] = null; orig
                        $i++;
                    }
                    

                }
                $x++;
            }

            $municipality = DB::table("municipalities")->pluck("name","id");
        
        return view('user/cropCalendar', array(
            "munis"=> $muni,
            "currentyear"=> $currentyear,
            "years"=> $year,
            "percentages"=> $percentage,
            "crops" => $crop, 
            "brgys" => $brgy, 
            "percs" => $perc,
            "municipalities" => $municipality
        ));
    }
}
