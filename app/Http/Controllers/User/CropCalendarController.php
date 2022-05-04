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
        $colorpalette = ['rgba(182, 207, 182)', 'rgba(171, 222, 230)', 'rgba(255, 229, 180)', 'rgba(224, 187, 228)', 'rgba(236, 234, 228)', 'rgba(212, 240, 240)', 'rgba(199, 206, 234)', 'rgba(236, 213, 227)', 'rgba(246, 234, 194)', 'rgba(186, 255, 201)', 'rgba(202, 255, 191)', 'rgba(255, 200, 162)', 'rgba(255, 255, 186)'];

        $x = 0;
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
                            $farmer[$key1][$j][$i] = Farming_data::where('barangay_id', $brgycount->id)->where('crop_id', $i+1)->distinct('crop_id')->pluck('farmer_id');

                            foreach($farmer[$key1][$j][$i] as $key2 => $sample)
                            {
                                $farmer[$key1][$j][$i][$key2] = Farmer::where('id', $sample)->value('name');
                            }

                            $color1[$x] = $colorpalette[$i];
                            $color2[$x] = $i;
                            
                            
                        } else 
                        {
                            $data[$key1][$j][$i] = 'null';
                        }
                    }
                    $x++;
                } else
                {
                    for($j = 0; $j <= 11; $j++)
                    {
                        $data[$key1][$j][$i] = 'empty';
                    }
                }
                
            }
        }
        $farming_chk = Farming_data::whereYear('created_at', '=', $date->year)->get();
        if($farming_chk->isEmpty())
        {
            return back()->with('cropmonitorfailed', 'Failed');
        }

        $color1 = array_unique($color1);

  
        $barangay = Barangay::where("municipality_id", Auth::user()->muni_address)->get(); 
        
        return view('user/cropCalendar', array(
            "munis"=> $muni,
            "currentyear"=> $currentyear,
            "crops" => $crop, 
            "brgys" => $brgy, 
            "data" => $data,
            "barangays" => $barangay,
            "farmers"    => $farmer,
            "colorpalettes" => $colorpalette,
            "color1s" => $color1,
            "color2s" => $color2,

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
        $currentyear = $request->year;
        $colorpalette = ['rgba(182, 207, 182)', 'rgba(171, 222, 230)', 'rgba(255, 229, 180)', 'rgba(224, 187, 228)', 'rgba(236, 234, 228)', 'rgba(212, 240, 240)', 'rgba(199, 206, 234)', 'rgba(236, 213, 227)', 'rgba(246, 234, 194)', 'rgba(186, 255, 201)', 'rgba(202, 255, 191)', 'rgba(255, 200, 162)', 'rgba(255, 255, 186)'];

        $x = 0;
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
                            $farmer[$key1][$j][$i] = Farming_data::where('barangay_id', $brgycount->id)->where('crop_id', $i+1)->distinct('crop_id')->pluck('farmer_id');

                            foreach($farmer[$key1][$j][$i] as $key2 => $sample)
                            {
                                $farmer[$key1][$j][$i][$key2] = Farmer::where('id', $sample)->value('name');
                            }

                            $color1[$x] = $colorpalette[$i];
                            $color2[$x] = $i;
                            
                            
                        } else 
                        {
                            $data[$key1][$j][$i] = 'null';
                        }
                    }
                    $x++;
                } else
                {
                    for($j = 0; $j <= 11; $j++)
                    {
                        $data[$key1][$j][$i] = 'empty';
                    }
                }
                
            }
        }

        $farming_chk = Farming_data::whereYear('created_at', '=', $request->year)->get();
        if($farming_chk->isEmpty())
        {
            return back()->with('cropmonitorfailed', 'Failed');
        }

        $color1 = array_unique($color1);

        $barangay = Barangay::where("municipality_id", Auth::user()->muni_address)->get(); 
        
        return view('user/cropCalendar', array(
            "munis"=> $muni,
            "currentyear"=> $currentyear,
            "crops" => $crop, 
            "brgys" => $brgy, 
            "data" => $data,
            "barangays" => $barangay,
            "farmers"    => $farmer,
            "colorpalettes" => $colorpalette,
            "color1s" => $color1,
            "color2s" => $color2,

        ));
    }
}
