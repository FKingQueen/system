<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Farming_data;
use App\Models\Crop;
use App\Models\Farmer;
use App\Models\Activity_file;
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
        $brgy = Barangay::where('municipality_id', Auth::user()->muni_address)->pluck('name');
        $brgycount = Barangay::where('municipality_id', Auth::user()->muni_address)->get();
        $brgyfirst = Barangay::where('municipality_id', Auth::user()->muni_address)->value('id');
        $currentyear = $date->year;

        foreach($brgycount as $key1 => $brgycount)
        {
            for($i = 0; $i <= 12; $i++)
            {
                $chk = Farming_data::where('municipality_id', Auth::user()->muni_address)->where('barangay_id', $brgycount->id)->where('crop_id', $i+1)->count();
                $chk1 = Activity_file::whereYear('date', '=' ,$currentyear)->where('crop_id', $i+1)->count();
                if($chk != 0 && $chk1 != 0)
                {
                    for($j = 0; $j <= 11; $j++)
                    {
                        if(Activity_file::whereYear('date', '=', $date->year)->whereMonth('date', '=' , $j+1)->where('crop_id', $i+1)->count() != 0)
                        {
                            $data[$key1][$j][$i] = Crop::where('id', $i+1)->value('name');
                        } else 
                        {
                            $data[$key1][$j][$i] = 'null';
                        }
                    }
                } else
                {
                    for($j = 0; $j <= 11; $j++)
                    {
                        $data[$key1][$j][$i] = 'empty';
                    }
                }
            }
        }
        $barangay = Barangay::where("municipality_id", Auth::user()->muni_address)->get(); 
        
        return view('user/cropCalendar', array(
            "munis"=> $muni,
            "currentyear"=> $currentyear,
            "crops" => $crop, 
            "brgys" => $brgy, 
            "data" => $data,
            "barangays" => $barangay
        ));
    }

    public function yearform(Request $request)
    {
        $muni = Municipality::where('id',Auth::user()->muni_address)->get();
        $crop = Crop::all();
        $date = Carbon::now();
        $brgy = Barangay::where('municipality_id', Auth::user()->muni_address)->pluck('name');
        $brgycount = Barangay::where('municipality_id', Auth::user()->muni_address)->get();
        $brgyfirst = Barangay::where('municipality_id', Auth::user()->muni_address)->value('id');
        $currentyear = $request->btnradio;


        foreach($brgycount as $key1 => $brgycount)
        {
            for($i = 0; $i <= 12; $i++)
            {
                $chk = Farming_data::where('municipality_id', Auth::user()->muni_address)->where('barangay_id', $brgycount->id)->where('crop_id', $i+1)->count();
                $chk1 = Activity_file::whereYear('date', '=' ,$currentyear)->where('crop_id', $i+1)->count();
                if($chk != 0 && $chk1 != 0)
                {
                    for($j = 0; $j <= 11; $j++)
                    {
                        if(Activity_file::whereMonth('date', '=' , $j+1)->whereYear('date', '=' ,$currentyear)->where('crop_id', $i+1)->count() != 0)
                        {
                            $data[$key1][$j][$i] = Crop::where('id', $i+1)->value('name');
                        } else 
                        {
                            $data[$key1][$j][$i] = 'null';
                        }
                    }
                } else
                {
                    for($j = 0; $j <= 11; $j++)
                    {
                        $data[$key1][$j][$i] = 'empty';
                    }
                }
            }
        }


        $barangay = Barangay::where("municipality_id", Auth::user()->muni_address)->get(); 
        
        return view('user/cropCalendar', array(
            "munis"=> $muni,
            "currentyear"=> $currentyear,
            "crops" => $crop, 
            "brgys" => $brgy, 
            "data" => $data,
            "barangays" => $barangay
        ));
    }
}
