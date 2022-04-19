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
        $N_crop = Crop::pluck('name');
        ////Crops Unit Stacked Bar Chart
        for($i = 0; $i <= 12; $i++)
        {
            $chk = Farming_data::whereYear('date', '=', 2022)->where('municipality_id', Auth::user()->muni_address)->where('crop_id', $i+1)->where('barangay_id', $request->barangay)->where('cropping_season_id', 1)->where('status', 0)->where('yield','!=',NULL)->count();
            if($chk != NULL || $chk != 0 )
            {
                $U_crop[$i] = number_format(Farming_data::whereYear('date', '=', 2022)->where('municipality_id', Auth::user()->muni_address)->where('crop_id', $i+1)->where('barangay_id', $request->barangay)->where('cropping_season_id', 1)->where('status', 0)->where('yield','!=',NULL)->pluck('unit')->sum()/1000, 2);
                $H_crop[$i] = number_format(Farming_data::whereYear('date', '=', 2022)->where('municipality_id', Auth::user()->muni_address)->where('crop_id', $i+1)->where('barangay_id', $request->barangay)->where('cropping_season_id', 1)->where('status', 0)->where('yield','!=',NULL)->pluck('lot_size')->sum(), 2);
            } else
            {
                $U_crop[$i] = 0;
                $H_crop[$i] = 0;
            }
            
        }

        ////Farmer Unit Stacked Bar Chart
        // Getting all farmer informttion in an array
        $F_id = Farming_data::whereYear('date', '=', 2022)->where('municipality_id', Auth::user()->muni_address)->where('barangay_id', $request->barangay)->where('cropping_season_id', 1)->where('status', 0)->where('yield','!=',NULL)->distinct('farmer_id')->pluck('farmer_id');
        //$Farmer = Farmer::whereYear('date', '=', 2022)->where('municipality_id', Auth::user()->muni_address)->where('barangay_id', $request->barangay)->get();
        
        foreach($F_id as $key1 => $f)
        {
            $Farmer[$key1] = Farmer::where('id', $f)->value('name');
        }

        if($F_id->isEmpty())
        {
            return back()->with('cropmonitorfailed', 'Failed');
        }

        
        //Getting all information of farming data into an array
        foreach($F_id as $key1 => $f)
        {
            $counter = Farming_data::whereYear('date', '=', 2022)->where('farmer_id', $f)->where('yield','!=',NULL)->where('municipality_id', Auth::user()->muni_address)->where('status', '0')->where('barangay_id', $request->barangay)->where('cropping_season_id', 1)->count();
            $FD_crop[$key1] = Farming_data::with('crop')->whereYear('date', '=', 2022)->where('cropping_season_id', 1)->where('farmer_id', $f)->where('yield','!=',NULL)->where('municipality_id', Auth::user()->muni_address)->where('status', '0')->where('barangay_id', $request->barangay)->get();
            
        }

        $chk = Farming_data::whereYear('date', '=', 2022)->where('cropping_season_id', 1)->where('yield','!=',NULL)->where('municipality_id', Auth::user()->muni_address)->where('status', '0')->where('barangay_id', $request->barangay)->count();
        
        if($chk == 0)
        {
            return back()->with('cropmonitorfailed', 'Failed');
        }
        // Getting the Farmer name
        $i = 0;
        foreach($F_id as $key1 => $f)
        {
            $chk = Farming_data::whereYear('date', '=', 2022)->where('farmer_id', $f)->where('status', 0)->where('yield','!=',NULL)->where('cropping_season_id', 1)->count();
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
        foreach($F_id as $key => $f)
        {
            $chk = Farming_data::whereYear('date', '=', 2022)->where('farmer_id', $f)->where('status', 0)->where('yield','!=',NULL)->where('cropping_season_id', 1)->count();  
            
            if($chk != 0)
            {
            $Bitter_gourd[$i] =  number_format(Farming_data::whereYear('date', '=', 2022)->where('farmer_id', $f)->where('cropping_season_id', 1)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 1)->sum('unit')/1000, 2);

            $Cabbage[$i]  = number_format(Farming_data::whereYear('date', '=', 2022)->where('farmer_id', $f)->where('cropping_season_id', 1)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 2)->sum('unit')/1000, 2);

            $Corn[$i]  = number_format(Farming_data::whereYear('date', '=', 2022)->where('farmer_id', $f)->where('cropping_season_id', 1)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 3)->sum('unit')/1000, 2);

            $Eggplant[$i]  = number_format(Farming_data::whereYear('date', '=', 2022)->where('farmer_id', $f)->where('cropping_season_id', 1)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 4)->sum('unit')/1000, 2);

            $Garlic[$i]  = number_format(Farming_data::whereYear('date', '=', 2022)->where('farmer_id', $f)->where('cropping_season_id', 1)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 5)->sum('unit')/1000, 2);

            $Ladys_finger[$i] = number_format(Farming_data::whereYear('date', '=', 2022)->where('farmer_id', $f)->where('cropping_season_id', 1)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 6)->sum('unit')/1000, 2);

            $Rice[$i] = number_format(Farming_data::whereYear('date', '=', 2022)->where('farmer_id', $f)->where('cropping_season_id', 1)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 7)->sum('unit')/1000, 2);

            $Onion[$i] = number_format(Farming_data::whereYear('date', '=', 2022)->where('farmer_id', $f)->where('cropping_season_id', 1)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 8)->sum('unit')/1000, 2);

            $Peanut[$i] = number_format(Farming_data::whereYear('date', '=', 2022)->where('farmer_id', $f)->where('cropping_season_id', 1)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 9)->sum('unit')/1000, 2);

            $String_bean[$i] = number_format(Farming_data::whereYear('date', '=', 2022)->where('farmer_id', $f)->where('cropping_season_id', 1)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 10)->sum('unit')/1000, 2);

            $Tobacco[$i] = number_format(Farming_data::whereYear('date', '=', 2022)->where('farmer_id', $f)->where('cropping_season_id', 1)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 11)->sum('unit')/1000, 2);

            $Tomato[$i] = number_format(Farming_data::whereYear('date', '=', 2022)->where('farmer_id', $f)->where('cropping_season_id', 1)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 12)->sum('unit')/1000, 2);
            
            $Water_melon[$i] = number_format(Farming_data::whereYear('date', '=', 2022)->where('farmer_id', $f)->where('cropping_season_id', 1)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 13)->sum('unit')/1000, 2);
            $i++;
            }
        }
        
        $jsbrgy = Barangay::where('id', $request->barangay)->value('name');
        $jsyear = '2022';
        $jscs   = 'Dry Season';
        $technician = Auth::user()->name;

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
            'U_crops'   =>$U_crop,
            'jsbrgy'    => $jsbrgy,
            'jsyear'    => $jsyear,
            'jscs'    => $jscs,
            'H_crops'    => $H_crop,
            'technician'    => $technician
        ));
    }

    public function yieldMonitoringsearch (Request $request)
    {

        $request->validate([
            'barangay'  => 'required',
            'year_id'   => 'required',
            'cropping_season'   => 'required',
        ]);

        
        ////Crops Unit Stacked Bar Chart
        $N_crop = Crop::pluck('name');
        for($i = 0; $i <= 12; $i++)
        {
            $chk = Farming_data::whereYear('date', '=', $request->year_id)->where('municipality_id', Auth::user()->muni_address)->where('crop_id', $i+1)->where('barangay_id', $request->barangay)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('yield','!=',NULL)->count();
            if($chk != NULL || $chk != 0 )
            {
                $U_crop[$i] = number_format(Farming_data::whereYear('date', '=', $request->year_id)->where('municipality_id', Auth::user()->muni_address)->where('crop_id', $i+1)->where('barangay_id', $request->barangay)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('yield','!=',NULL)->pluck('unit')->sum()/1000, 2);
                $H_crop[$i] = number_format(Farming_data::whereYear('date', '=', $request->year_id)->where('municipality_id', Auth::user()->muni_address)->where('crop_id', $i+1)->where('barangay_id', $request->barangay)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('yield','!=',NULL)->pluck('lot_size')->sum(), 2);
            } else
            {
                $U_crop[$i] = 0;
                $H_crop[$i] = 0;
            }
            
        }
        ////Farmer Unit Stacked Bar Chart
        // Getting all farmer informttion in an array
        $F_id = Farming_data::whereYear('date', '=', $request->year_id)->where('municipality_id', Auth::user()->muni_address)->where('barangay_id', $request->barangay)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('yield','!=',NULL)->distinct('farmer_id')->pluck('farmer_id');
        //$Farmer = Farmer::whereYear('date', '=', 2022)->where('municipality_id', Auth::user()->muni_address)->where('barangay_id', $request->barangay)->get();
        
        foreach($F_id as $key1 => $f)
        {
            $Farmer[$key1] = Farmer::where('id', $f)->value('name');
        }

        if($F_id->isEmpty())
        {
            return back()->with('cropmonitorfailed', 'Failed');
        }

        
        //Getting all information of farming data into an array
        foreach($F_id as $key1 => $f)
        {
            $counter = Farming_data::whereYear('date', '=', $request->year_id)->where('farmer_id', $f)->where('yield','!=',NULL)->where('municipality_id', Auth::user()->muni_address)->where('status', '0')->where('barangay_id', $request->barangay)->where('cropping_season_id', $request->cropping_season)->count();
            $FD_crop[$key1] = Farming_data::with('crop')->whereYear('date', '=', $request->year_id)->where('cropping_season_id', $request->cropping_season)->where('farmer_id', $f)->where('yield','!=',NULL)->where('municipality_id', Auth::user()->muni_address)->where('status', '0')->where('barangay_id', $request->barangay)->get();
            
        }

        $chk = Farming_data::whereYear('date', '=', $request->year_id)->where('cropping_season_id', $request->cropping_season)->where('yield','!=',NULL)->where('municipality_id', Auth::user()->muni_address)->where('status', '0')->where('barangay_id', $request->barangay)->count();
        
        if($chk == 0)
        {
            return back()->with('cropmonitorfailed', 'Failed');
        }
        // Getting the Farmer name
        $i = 0;
        foreach($F_id as $key1 => $f)
        {
            $chk = Farming_data::whereYear('date', '=', $request->year_id)->where('farmer_id', $f)->where('status', 0)->where('yield','!=',NULL)->where('cropping_season_id', $request->cropping_season)->count();
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
        foreach($F_id as $key => $f)
        {
            $chk = Farming_data::whereYear('date', '=', $request->year_id)->where('farmer_id', $f)->where('status', 0)->where('yield','!=',NULL)->where('cropping_season_id', $request->cropping_season)->count();  
            
            if($chk != 0)
            {
            $Bitter_gourd[$i] =  number_format(Farming_data::whereYear('date', '=', $request->year_id)->where('farmer_id', $f)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 1)->sum('unit')/1000, 2);

            $Cabbage[$i]  = number_format(Farming_data::whereYear('date', '=', $request->year_id)->where('farmer_id', $f)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 2)->sum('unit')/1000, 2);

            $Corn[$i]  = number_format(Farming_data::whereYear('date', '=', $request->year_id)->where('farmer_id', $f)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 3)->sum('unit')/1000, 2);

            $Eggplant[$i]  = number_format(Farming_data::whereYear('date', '=', $request->year_id)->where('farmer_id', $f)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 4)->sum('unit')/1000, 2);

            $Garlic[$i]  = number_format(Farming_data::whereYear('date', '=', $request->year_id)->where('farmer_id', $f)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 5)->sum('unit')/1000, 2);

            $Ladys_finger[$i] = number_format(Farming_data::whereYear('date', '=', $request->year_id)->where('farmer_id', $f)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 6)->sum('unit')/1000, 2);

            $Rice[$i] = number_format(Farming_data::whereYear('date', '=', $request->year_id)->where('farmer_id', $f)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 7)->sum('unit')/1000, 2);

            $Onion[$i] = number_format(Farming_data::whereYear('date', '=', $request->year_id)->where('farmer_id', $f)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 8)->sum('unit')/1000, 2);

            $Peanut[$i] = number_format(Farming_data::whereYear('date', '=', $request->year_id)->where('farmer_id', $f)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 9)->sum('unit')/1000, 2);

            $String_bean[$i] = number_format(Farming_data::whereYear('date', '=', $request->year_id)->where('farmer_id', $f)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 10)->sum('unit')/1000, 2);

            $Tobacco[$i] = number_format(Farming_data::whereYear('date', '=', $request->year_id)->where('farmer_id', $f)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 11)->sum('unit')/1000, 2);

            $Tomato[$i] = number_format(Farming_data::whereYear('date', '=', $request->year_id)->where('farmer_id', $f)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 12)->sum('unit')/1000, 2);
            
            $Water_melon[$i] = number_format(Farming_data::whereYear('date', '=', $request->year_id)->where('farmer_id', $f)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 13)->sum('unit')/1000, 2);
            $i++;
            }
        }
        
        $jsbrgy = Barangay::where('id', $request->barangay)->value('name');
        $jsyear = $request->year_id;
        if($request->cropping_season == 1)
        {
            $jscs   = 'Dry Season';
        } else if($request->cropping_season == 2)
        {
            $jscs   = 'Wet Season';
        }
        $technician = Auth::user()->name;

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
            'U_crops'   =>$U_crop,
            'jsbrgy'    => $jsbrgy,
            'jsyear'    => $jsyear,
            'jscs'    => $jscs,
            'H_crops'    => $H_crop,
            'technician'    => $technician
        ));
    }
}
