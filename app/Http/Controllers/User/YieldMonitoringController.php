<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Municipality;
use App\Models\Farmer;
use App\Models\Barangay;
use App\Models\Farming_data;
use App\Models\Activity_file;
use DateTime;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Auth;

class YieldMonitoringController extends Controller
{
    public function yieldMonitoring(Request $request)
    {   
        $Farmer = Farmer::whereYear('created_at', '=', 2022)->where('municipality_id', Auth::user()->muni_address)->where('barangay_id', 52)->get();
        $F_id = Farmer::whereYear('created_at', '=', 2022)->where('municipality_id', Auth::user()->muni_address)->where('barangay_id', 52)->pluck('id');
        
        foreach($F_id as $key1 => $f)
        {
            $counter = Farming_data::whereYear('created_at', '=', 2022)->where('farmer_id', $F_id[$key1])->where('yield','!=',NULL)->where('municipality_id', Auth::user()->muni_address)->where('status', '0')->where('barangay_id', 52)->count();
            $FD_crop[$key1] = Farming_data::with('crop')->whereYear('created_at', '=', 2022)->where('farmer_id', $F_id[$key1])->where('yield','!=',NULL)->where('municipality_id', Auth::user()->muni_address)->where('status', '0')->where('barangay_id', 52)->get();
            
        }
        
        $i = 0;
        foreach($Farmer as $key1 => $fars)
        {
            $chk = Farming_data::where('farmer_id', $fars->id)->where('status', 0)->count();
            if($chk != 0)
            {
                foreach($FD_crop[$key1] as $key2 => $fs)
                {
                    $n_farmer[$i] = Farmer::where('id', $FD_crop[$key1][$key2]->farmer_id)->value('name');
                }
                $i++;
            }
        }

        
        $i = 0;
        $total_unit = 0;
        foreach($Farmer as $key => $f)
        {
            $chk = Farming_data::where('farmer_id', $f->id)->where('status', 0)->count();  
            
            if($chk != 0)
            {
 
            $Bitter_gourd[$i] = Farming_data::where('farmer_id', $f->id)->where('status', 0)->where('crop_id', 1)->value('unit');

            $Cabbage[$i]  = Farming_data::where('farmer_id', $f->id)->where('status', 0)->where('crop_id', 2)->value('unit');

            $Corn[$i]  = Farming_data::where('farmer_id', $f->id)->where('status', 0)->where('crop_id', 3)->value('unit');

            $Eggplant[$i]  = Farming_data::where('farmer_id', $f->id)->where('status', 0)->where('crop_id', 4)->value('unit');

            $Garlic[$i]  = Farming_data::where('farmer_id', $f->id)->where('status', 0)->where('crop_id', 5)->value('unit');

            $Ladys_finger[$i] = Farming_data::where('farmer_id', $f->id)->where('status', 0)->where('crop_id', 6)->value('unit');

            $Rice[$i] = Farming_data::where('farmer_id', $f->id)->where('status', 0)->where('crop_id', 7)->value('unit');

            $Onion[$i] = Farming_data::where('farmer_id', $f->id)->where('status', 0)->where('crop_id', 8)->value('unit');

            $Peanut[$i] = Farming_data::where('farmer_id', $f->id)->where('status', 0)->where('crop_id', 9)->value('unit');

            $String_bean[$i] = Farming_data::where('farmer_id', $f->id)->where('status', 0)->where('crop_id', 10)->value('unit');

            $Tobacco[$i] = Farming_data::where('farmer_id', $f->id)->where('status', 0)->where('crop_id', 11)->value('unit');

            $Tomato[$i] = Farming_data::where('farmer_id', $f->id)->where('status', 0)->where('crop_id', 12)->value('unit');

            $Tomato[$i] = Farming_data::where('farmer_id', $f->id)->where('status', 0)->where('crop_id', 12)->value('unit');
            
            $Water_melon[$i] = Farming_data::where('farmer_id', $f->id)->where('status', 0)->where('crop_id', 13)->value('unit');
            $i++;
            }
        }


        $barangay = Barangay::where("municipality_id", Auth::user()->muni_address)->get();
        return view('user/yieldMonitoring', array(
            "barangays" => $barangay, 
            'Bitter_gourds'   => $Bitter_gourd,
            'Cabbages'   => $Cabbage,
            'Corns'   => $Corn,
            'Eggplants'   => $Eggplant,
            'Garlics'   => $Garlic,
            'Ladys_fingers'   => $Ladys_finger,
            'Rices'   => $Rice,
            'Onions'   => $Onion,
            'Peanuts'   => $Peanut,
            'String_beans'   => $String_bean,
            'Tobaccos'   => $Tobacco,
            'Tomatos'   => $Tomato,
            'Water_melons'   => $Water_melon,
            'n_farmers'   => $n_farmer
        ));
    }
}
