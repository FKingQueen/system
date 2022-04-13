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
use Auth;

class CropCalendarController extends Controller
{
    public function cropCalendar ()
    {   

        $muni = Municipality::where('id',Auth::user()->muni_address)->get();


        $crop = Crop::all();
        $date = Carbon::now();
        $brgy = Barangay::where('municipality_id', Auth::user()->muni_address)->get();
        $brgycount = Barangay::where('municipality_id', Auth::user()->muni_address)->get();
        $brgyfirst = Barangay::where('municipality_id', Auth::user()->muni_address)->value('id');
        $total = Farming_data::whereYear('created_at', $date->year)->where('municipality_id', Auth::user()->muni_address)->count();
        if($total==0)
        {
            $total=1;
        }
        $currentyear = $date->year;

        foreach($brgycount as $key => $brgycount)
        {
            for($i = 0; $i <= 11; $i++)
            {
                for($j = 0; $j <= 12; $i++)
                {

                }
            }
        }

        $k=1;
        $x=$brgyfirst;
        $i = 0;
            while($i<=12*$brgycount-1)
            {
                for($p=1;$p<=12;$p++)  
                {
                    $chk = Farming_data::whereMonth('created_at', '=', $p )->whereYear('created_at', '=', $date->year)->where('barangay_id', $x)->count();
                    if($chk!=0)
                    {
                        for($j = 1; $j<=Crop::count(); $j++)
                        {
                            $perc[$i][$j] = number_format((Farming_data::whereMonth('created_at', '=', $p )->whereYear('created_at', '=', $date->year)->where('barangay_id', $x)->where('crop_id', $j)->count() / $total)*100,0);
                        }
                        $i++;
                    } 
                    else  {
                        $perc[$i][0] = null;
                        // $perc[$i][0] = null; orig
                        $i++;
                    }
                }
                $x++;
            }

            $barangay = Barangay::where("municipality_id", Auth::user()->muni_address)->get(); 
        
        return view('user/cropCalendar', array(
            "munis"=> $muni,
            "currentyear"=> $currentyear,
            "crops" => $crop, 
            "brgys" => $brgy, 
            "percs" => $perc,
            "barangays" => $barangay
        ));
    }

    public function yearform(Request $request)
    {
        $muni = Municipality::where('id',Auth::user()->muni_address)->get();

        $crop = Crop::all();
        $brgy = Barangay::where('municipality_id', Auth::user()->muni_address)->get();
        $brgycount = Barangay::where('municipality_id', Auth::user()->muni_address)->count();
        $brgyfirst = Barangay::where('municipality_id', Auth::user()->muni_address)->value('id');


        // dd($request->year_id);

        for($i = 4; $i >= 0; $i--)
        {

            for($j = 0; $j <= Crop::count()-1; $j++)
            {
                $total = Farming_data::whereYear('created_at', '=', $request->btnradio)->count();

                for($k = 0; $k <= Crop::count()-1; $k++)
                {
                    if($total!=0)
                    {
                        $percentage[$i][$k] = number_format((Farming_data::whereYear('created_at', '=', $request->btnradio)->where('crop_id', $k+1)->count() / $total)*100, 0);
                    }
                    else {
                        $percentage[$i][$k] = 0;
                    }
                }
            }
            
            $total=0;
        }



        $total = Farming_data::whereYear('created_at', $request->btnradio)->where('municipality_id', Auth::user()->muni_address)->count();
        if($total==0)
        {
            $total=1;
        }

        $currentyear = $request->btnradio;

        $k=1;
        $x=$brgyfirst;
        $i = 0;
            while($i<=12*$brgycount-1)
            {
                for($p=1;$p<=12;$p++)  
                {
                    $chk = Farming_data::whereMonth('created_at', '=', $p )->whereYear('created_at', '=', $request->btnradio)->where('barangay_id', $x)->count();
                    if($chk!=0)
                    {
                        for($j = 1; $j<=Crop::count(); $j++)
                        {
                            $perc[$i][$j] = number_format((Farming_data::whereMonth('created_at', '=', $p )->whereYear('created_at', '=', $request->btnradio)->where('barangay_id', $x)->where('crop_id', $j)->count() / $total)*100,0);
                        }
                        $i++;
                    } 
                    else  {
                        $perc[$i][0] = null;
                        // $perc[$i][0] = null; orig
                        $i++;
                    }
                    

                }
                $x++;
            }

            $barangay = Barangay::where("municipality_id", Auth::user()->muni_address)->get(); 
        
        return view('user/cropCalendar', array(
            "munis"=> $muni,
            "currentyear"=> $currentyear,
            "percentages"=> $percentage,
            "crops" => $crop, 
            "brgys" => $brgy, 
            "percs" => $perc,
            "barangays" => $barangay
        ));
        
    }
}
