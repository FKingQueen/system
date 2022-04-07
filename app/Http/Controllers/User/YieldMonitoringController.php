<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Municipality;
use App\Models\Farmer;
use App\Models\Crop;
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
        $request->validate([
            'barangay'  => 'required',
        ]);

        ////Crops Unit Stacked Bar Chart
        $N_crop = Crop::pluck('name');
        $ID_crop = Crop::pluck('id');
        foreach($ID_crop as $key => $ID_crops)
        {
            $U_crop[$key] = number_format(Farming_data::whereYear('created_at', '=', 2022)->where('municipality_id', Auth::user()->muni_address)->where('crop_id', $ID_crops)->where('barangay_id', $request->barangay)->where('cropping_season_id', 1)->pluck('unit')->sum()/1000, 2);
        }  

        ////Farmer Unit Stacked Bar Chart
        // Getting all farmer informttion in an array
        $Farmer = Farmer::whereYear('created_at', '=', 2022)->where('municipality_id', Auth::user()->muni_address)->where('barangay_id', $request->barangay)->get();
        if($Farmer->isEmpty())
        {
            return back()->with('cropmonitorfailed', 'Failed');
        }

        $F_id = Farmer::whereYear('created_at', '=', 2022)->where('municipality_id', Auth::user()->muni_address)->where('barangay_id', $request->barangay)->pluck('id');
        
        //Getting all information of farming data into an array
        foreach($F_id as $key1 => $f)
        {
            $counter = Farming_data::whereYear('created_at', '=', 2022)->where('farmer_id', $F_id[$key1])->where('yield','!=',NULL)->where('municipality_id', Auth::user()->muni_address)->where('status', '0')->where('barangay_id', $request->barangay)->where('cropping_season_id', 1)->count();
            $FD_crop[$key1] = Farming_data::with('crop')->whereYear('created_at', '=', 2022)->where('cropping_season_id', 1)->where('farmer_id', $F_id[$key1])->where('yield','!=',NULL)->where('municipality_id', Auth::user()->muni_address)->where('status', '0')->where('barangay_id', $request->barangay)->get();
            
        }

        $chk = Farming_data::whereYear('created_at', '=', 2022)->where('cropping_season_id', 1)->where('yield','!=',NULL)->where('municipality_id', Auth::user()->muni_address)->where('status', '0')->where('barangay_id', $request->barangay)->count();
        
        if($chk == 0)
        {
            return back()->with('cropmonitorfailed', 'Failed');
        }
        // Getting the Farmer name
        $i = 0;
        foreach($Farmer as $key1 => $fars)
        {
            $chk = Farming_data::where('farmer_id', $fars->id)->where('status', 0)->where('cropping_season_id', 1)->count();
            if($chk != 0)
            {
                foreach($FD_crop[$key1] as $key2 => $fs)
                {
                    $n_farmer[$i] = Farmer::where('id', $FD_crop[$key1][$key2]->farmer_id)->value('name');
                }
                $i++;
            }
        }

        // Getting all crop count , one by one
        $i = 0;
        $total_unit = 0;
        foreach($Farmer as $key => $f)
        {
            $chk = Farming_data::where('farmer_id', $f->id)->where('status', 0)->where('cropping_season_id', 1)->count();  
            
            if($chk != 0)
            {
 
            $Bitter_gourd[$i] =  number_format(Farming_data::where('farmer_id', $f->id)->where('cropping_season_id', 1)->where('status', 0)->where('crop_id', 1)->value('unit')/1000, 2);

            $Cabbage[$i]  = number_format(Farming_data::where('farmer_id', $f->id)->where('cropping_season_id', 1)->where('status', 0)->where('crop_id', 2)->value('unit')/1000, 2);

            $Corn[$i]  = number_format(Farming_data::where('farmer_id', $f->id)->where('cropping_season_id', 1)->where('status', 0)->where('crop_id', 3)->value('unit')/1000, 2);

            $Eggplant[$i]  = number_format(Farming_data::where('farmer_id', $f->id)->where('cropping_season_id', 1)->where('status', 0)->where('crop_id', 4)->value('unit')/1000, 2);

            $Garlic[$i]  = number_format(Farming_data::where('farmer_id', $f->id)->where('cropping_season_id', 1)->where('status', 0)->where('crop_id', 5)->value('unit')/1000, 2);

            $Ladys_finger[$i] = number_format(Farming_data::where('farmer_id', $f->id)->where('cropping_season_id', 1)->where('status', 0)->where('crop_id', 6)->value('unit')/1000, 2);

            $Rice[$i] = number_format(Farming_data::where('farmer_id', $f->id)->where('cropping_season_id', 1)->where('status', 0)->where('crop_id', 7)->value('unit')/1000, 2);

            $Onion[$i] = number_format(Farming_data::where('farmer_id', $f->id)->where('cropping_season_id', 1)->where('status', 0)->where('crop_id', 8)->value('unit')/1000, 2);

            $Peanut[$i] = number_format(Farming_data::where('farmer_id', $f->id)->where('cropping_season_id', 1)->where('status', 0)->where('crop_id', 9)->value('unit')/1000, 2);

            $String_bean[$i] = number_format(Farming_data::where('farmer_id', $f->id)->where('cropping_season_id', 1)->where('status', 0)->where('crop_id', 10)->value('unit')/1000, 2);

            $Tobacco[$i] = number_format(Farming_data::where('farmer_id', $f->id)->where('cropping_season_id', 1)->where('status', 0)->where('crop_id', 11)->value('unit')/1000, 2);

            $Tomato[$i] = number_format(Farming_data::where('farmer_id', $f->id)->where('cropping_season_id', 1)->where('status', 0)->where('crop_id', 12)->value('unit')/1000, 2);

            $Tomato[$i] = number_format(Farming_data::where('farmer_id', $f->id)->where('cropping_season_id', 1)->where('status', 0)->where('crop_id', 12)->value('unit')/1000, 2);
            
            $Water_melon[$i] = number_format(Farming_data::where('farmer_id', $f->id)->where('cropping_season_id', 1)->where('status', 0)->where('crop_id', 13)->value('unit')/1000, 2);
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
            'n_farmers'   => $n_farmer,
            'N_crops'   => $N_crop,
            'U_crops'   =>$U_crop
        ));
    }

    public function yieldMonitoringsearch (Request $request)
    {

        $request->validate([
            'barangay'  => 'required',
            'year_id'   => 'required',
            'cropping_season'   => 'required',
        ]);

        $chk = Farming_data::whereYear('created_at', '=', $request->year_id)->where('cropping_season_id', $request->cropping_season)->where('yield','!=',NULL)->where('municipality_id', Auth::user()->muni_address)->where('status', '0')->where('barangay_id', $request->barangay)->count();
        
        if($chk == 0)
        {
            return back()->with('cropmonitorfailed', 'Failed');
        }
        
        ////Crops Unit Stacked Bar Chart
        $N_crop = Crop::pluck('name');
        $ID_crop = Crop::pluck('id');
        foreach($ID_crop as $key => $ID_crops)
        {
            $U_crop[$key] = number_format(Farming_data::whereYear('created_at', '=', $request->year_id)->where('municipality_id', Auth::user()->muni_address)->where('id', $ID_crops)->where('barangay_id', $request->barangay)->where('cropping_season_id', $request->cropping_season)->pluck('unit')->sum()/1000, 2);
        } 

        
        
        $FD_chk = Farming_data::whereYear('created_at', '=', $request->year_id)->where('municipality_id', Auth::user()->muni_address)->where('barangay_id', $request->barangay)->where('cropping_season_id', $request->cropping_season)->pluck('id');

        ////Farmer Unit Stacked Bar Chart
        // Getting all farmer informttion in an array
        $Farmer = Farmer::whereYear('created_at', '=', $request->year_id)->where('municipality_id', Auth::user()->muni_address)->where('barangay_id', $request->barangay)->get();
        if($Farmer->isEmpty() )
        {
            return back()->with('cropmonitorfailed', 'Failed');
        } else if ($FD_chk->isEmpty())
        {
            return back()->with('cropmonitorfailed', 'Failed');
        }
        $F_id = Farmer::whereYear('created_at', '=', $request->year_id)->where('municipality_id', Auth::user()->muni_address)->where('barangay_id', $request->barangay)->pluck('id');
        
        //Getting all information of farming data into an array
        foreach($F_id as $key1 => $f)
        {
            $counter = Farming_data::whereYear('created_at', '=', $request->year_id)->where('farmer_id', $F_id[$key1])->where('yield','!=',NULL)->where('municipality_id', Auth::user()->muni_address)->where('status', '0')->where('barangay_id', $request->barangay)->where('cropping_season_id', $request->cropping_season)->count();
            $FD_crop[$key1] = Farming_data::with('crop')->whereYear('created_at', '=', $request->year_id)->where('cropping_season_id', $request->cropping_season)->where('farmer_id', $F_id[$key1])->where('yield','!=',NULL)->where('municipality_id', Auth::user()->muni_address)->where('status', '0')->where('barangay_id', $request->barangay)->get();
            
        }


        
        // Getting the Farmer name
        $i = 0;
        foreach($Farmer as $key1 => $fars)
        {
            $chk = Farming_data::where('farmer_id', $fars->id)->where('status', 0)->where('cropping_season_id', $request->cropping_season)->count();
            if($chk != 0)
            {
                foreach($FD_crop[$key1] as $key2 => $fs)
                {
                    $n_farmer[$i] = Farmer::where('id', $FD_crop[$key1][$key2]->farmer_id)->value('name');
                }
                $i++;
            }
        }

        // Getting all crop count , one by one
        $i = 0;
        $total_unit = 0;
        foreach($Farmer as $key => $f)
        {
            $chk = Farming_data::where('farmer_id', $f->id)->where('status', 0)->where('cropping_season_id', $request->cropping_season)->count();  
            
            if($chk != 0)
            {
 
            $Bitter_gourd[$i] =  number_format(Farming_data::where('farmer_id', $f->id)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('crop_id', 1)->value('unit')/1000, 2);

            $Cabbage[$i]  = number_format(Farming_data::where('farmer_id', $f->id)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('crop_id', 2)->value('unit')/1000, 2);

            $Corn[$i]  = number_format(Farming_data::where('farmer_id', $f->id)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('crop_id', 3)->value('unit')/1000, 2);

            $Eggplant[$i]  = number_format(Farming_data::where('farmer_id', $f->id)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('crop_id', 4)->value('unit')/1000, 2);

            $Garlic[$i]  = number_format(Farming_data::where('farmer_id', $f->id)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('crop_id', 5)->value('unit')/1000, 2);

            $Ladys_finger[$i] = number_format(Farming_data::where('farmer_id', $f->id)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('crop_id', 6)->value('unit')/1000, 2);

            $Rice[$i] = number_format(Farming_data::where('farmer_id', $f->id)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('crop_id', 7)->value('unit')/1000, 2);

            $Onion[$i] = number_format(Farming_data::where('farmer_id', $f->id)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('crop_id', 8)->value('unit')/1000, 2);

            $Peanut[$i] = number_format(Farming_data::where('farmer_id', $f->id)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('crop_id', 9)->value('unit')/1000, 2);

            $String_bean[$i] = number_format(Farming_data::where('farmer_id', $f->id)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('crop_id', 10)->value('unit')/1000, 2);

            $Tobacco[$i] = number_format(Farming_data::where('farmer_id', $f->id)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('crop_id', 11)->value('unit')/1000, 2);

            $Tomato[$i] = number_format(Farming_data::where('farmer_id', $f->id)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('crop_id', 12)->value('unit')/1000, 2);

            $Tomato[$i] = number_format(Farming_data::where('farmer_id', $f->id)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('crop_id', 12)->value('unit')/1000, 2);
            
            $Water_melon[$i] = number_format(Farming_data::where('farmer_id', $f->id)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('crop_id', 13)->value('unit')/1000, 2);
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
            'n_farmers'   => $n_farmer,
            'N_crops'   => $N_crop,
            'U_crops'   =>$U_crop
        ));
    }
}
