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
use App\Models\Cropping_season;
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
            $chk = Farming_data::whereYear('date', '=', 2022)->where('municipality_id', Auth::user()->muni_address)->where('crop_id', $i+1)->where('barangay_id', $request->barangay)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('yield','!=',NULL)->count();
            if($chk != NULL || $chk != 0 )
            {
                $U_crop[$i] = Farming_data::whereYear('date', '=', 2022)->where('municipality_id', Auth::user()->muni_address)->where('crop_id', $i+1)->where('barangay_id', $request->barangay)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('yield','!=',NULL)->pluck('yield')->sum();
                $H_crop[$i] = Farming_data::whereYear('date', '=', 2022)->where('municipality_id', Auth::user()->muni_address)->where('crop_id', $i+1)->where('barangay_id', $request->barangay)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('yield','!=',NULL)->pluck('lot_size')->sum();
            } else
            {
                $U_crop[$i] = 0;
                $H_crop[$i] = 0;
            }
            
        }
        
        ////Farmer Unit Stacked Bar Chart
        // Getting all farmer informttion in an array
        $F_id = Farming_data::whereYear('date', '=', 2022)->where('municipality_id', Auth::user()->muni_address)->where('barangay_id', $request->barangay)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('yield','!=',NULL)->distinct('farmer_id')->pluck('farmer_id');
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
            $counter = Farming_data::whereYear('date', '=', 2022)->where('farmer_id', $f)->where('yield','!=',NULL)->where('municipality_id', Auth::user()->muni_address)->where('status', '0')->where('barangay_id', $request->barangay)->where('cropping_season_id', $request->cropping_season)->count();
            $FD_crop[$key1] = Farming_data::with('crop')->whereYear('date', '=', 2022)->where('cropping_season_id', $request->cropping_season)->where('farmer_id', $f)->where('yield','!=',NULL)->where('municipality_id', Auth::user()->muni_address)->where('status', '0')->where('barangay_id', $request->barangay)->get();
            
        }

        $chk = Farming_data::whereYear('date', '=', 2022)->where('cropping_season_id', $request->cropping_season)->where('yield','!=',NULL)->where('municipality_id', Auth::user()->muni_address)->where('status', '0')->where('barangay_id', $request->barangay)->count();
        
        if($chk == 0)
        {
            return back()->with('cropmonitorfailed', 'Failed');
        }
        // Getting the Farmer name
        $i = 0;
        foreach($F_id as $key1 => $f)
        {
            $chk = Farming_data::whereYear('date', '=', 2022)->where('farmer_id', $f)->where('status', 0)->where('yield','!=',NULL)->where('cropping_season_id', $request->cropping_season)->count();
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
            $chk = Farming_data::whereYear('date', '=', 2022)->where('farmer_id', $f)->where('status', 0)->where('yield','!=',NULL)->where('cropping_season_id', $request->cropping_season)->count();  
            
            if($chk != 0)
            {
            $Bitter_gourd[$i] =  number_format(Farming_data::whereYear('date', '=', 2022)->where('farmer_id', $f)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 1)->sum('yield')/1000, 2);

            $Cabbage[$i]  = number_format(Farming_data::whereYear('date', '=', 2022)->where('farmer_id', $f)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 2)->sum('yield')/1000, 2);

            $Corn[$i]  = number_format(Farming_data::whereYear('date', '=', 2022)->where('farmer_id', $f)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 3)->sum('yield')/1000, 2);

            $Eggplant[$i]  = number_format(Farming_data::whereYear('date', '=', 2022)->where('farmer_id', $f)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 4)->sum('yield')/1000, 2);

            $Garlic[$i]  = number_format(Farming_data::whereYear('date', '=', 2022)->where('farmer_id', $f)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 5)->sum('yield')/1000, 2);

            $Ladys_finger[$i] = number_format(Farming_data::whereYear('date', '=', 2022)->where('farmer_id', $f)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 6)->sum('yield')/1000, 2);

            $Rice[$i] = number_format(Farming_data::whereYear('date', '=', 2022)->where('farmer_id', $f)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 7)->sum('yield')/1000, 2);

            $Onion[$i] = number_format(Farming_data::whereYear('date', '=', 2022)->where('farmer_id', $f)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 8)->sum('yield')/1000, 2);

            $Peanut[$i] = number_format(Farming_data::whereYear('date', '=', 2022)->where('farmer_id', $f)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 9)->sum('yield')/1000, 2);

            $String_bean[$i] = number_format(Farming_data::whereYear('date', '=', 2022)->where('farmer_id', $f)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 10)->sum('yield')/1000, 2);

            $Tobacco[$i] = number_format(Farming_data::whereYear('date', '=', 2022)->where('farmer_id', $f)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 11)->sum('yield')/1000, 2);

            $Tomato[$i] = number_format(Farming_data::whereYear('date', '=', 2022)->where('farmer_id', $f)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 12)->sum('yield')/1000, 2);
            
            $Water_melon[$i] = number_format(Farming_data::whereYear('date', '=', 2022)->where('farmer_id', $f)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 13)->sum('yield')/1000, 2);
            $i++;
            }
        }
    

        $n_brgy = Barangay::where('municipality_id', Auth::user()->muni_address)->get();
        
        // Getting all crop count , one by one
        $i = 0;
        $total_unit = 0;
        foreach($n_brgy as $key => $n_b)
        {
            $chk = Farming_data::whereYear('date', '=', 2022)->where('status', 0)->where('yield','!=',NULL)->where('cropping_season_id', $request->cropping_season)->where('barangay_id', $n_b->id)->count();  
            
            if($chk != 0)
            {
            $Bitter_gourd_com[$i] =  number_format(Farming_data::whereYear('date', '=', 2022)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 1)->where('barangay_id', $n_b->id)->sum('yield')/1000, 2);

            $Cabbage_com[$i]  = number_format(Farming_data::whereYear('date', '=', 2022)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 2)->where('barangay_id', $n_b->id)->sum('yield')/1000, 2);

            $Corn_com[$i]  = number_format(Farming_data::whereYear('date', '=', 2022)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 3)->where('barangay_id', $n_b->id)->sum('yield')/1000, 2);

            $Eggplant_com[$i]  = number_format(Farming_data::whereYear('date', '=', 2022)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 4)->where('barangay_id', $n_b->id)->sum('yield')/1000, 2);

            $Garlic_com[$i]  = number_format(Farming_data::whereYear('date', '=', 2022)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 5)->where('barangay_id', $n_b->id)->sum('yield')/1000, 2);

            $Ladys_finger_com[$i] = number_format(Farming_data::whereYear('date', '=', 2022)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 6)->where('barangay_id', $n_b->id)->sum('yield')/1000, 2);

            $Rice_com[$i] = number_format(Farming_data::whereYear('date', '=', 2022)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 7)->where('barangay_id', $n_b->id)->sum('yield')/1000, 2);

            $Onion_com[$i] = number_format(Farming_data::whereYear('date', '=', 2022)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 8)->where('barangay_id', $n_b->id)->sum('yield')/1000, 2);

            $Peanut_com[$i] = number_format(Farming_data::whereYear('date', '=', 2022)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 9)->where('barangay_id', $n_b->id)->sum('yield')/1000, 2);

            $String_bean_com[$i] = number_format(Farming_data::whereYear('date', '=', 2022)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 10)->where('barangay_id', $n_b->id)->sum('yield')/1000, 2);

            $Tobacco_com[$i] = number_format(Farming_data::whereYear('date', '=', 2022)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 11)->where('barangay_id', $n_b->id)->sum('yield')/1000, 2);

            $Tomato_com[$i] = number_format(Farming_data::whereYear('date', '=', 2022)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 12)->where('barangay_id', $n_b->id)->sum('yield')/1000, 2);
            
            $Water_melon_com[$i] = number_format(Farming_data::whereYear('date', '=', 2022)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 13)->where('barangay_id', $n_b->id)->sum('yield')/1000, 2);
            
            $name_brgy[$i] = Barangay::where('id', $n_b->id)->value('name');
            $i++;
            }
        }

        $jsbrgy = Barangay::where('id', $request->barangay)->value('name');
        $jsyear = '2022';
        $jscs   = Cropping_season::where('id', $request->cropping_season)->value('name');
        $technician = Auth::user()->name;
        $muni = Municipality::where('id', Auth::user()->muni_address)->value('name');

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
            'technician'    => $technician,
            'muni'    => $muni,

            'Bitter_gourds_com'   => $Bitter_gourd_com,
            'Cabbages_com'   => $Cabbage_com,
            'Corns_com'   => $Corn_com,
            'Eggplants_com'   => $Eggplant_com,
            'Garlics_com'   => $Garlic_com,
            'Ladys_fingers_com'   => $Ladys_finger_com,
            'Rices_com'   => $Rice_com,
            'Onions_com'   => $Onion_com,
            'Peanuts_com'   => $Peanut_com,
            'String_beans_com'   => $String_bean_com,
            'Tobaccos_com'   => $Tobacco_com,
            'Tomatos_com'   => $Tomato_com,
            'Water_melons_com'   => $Water_melon_com,
            'n_brgys'   => $name_brgy

        ));
    }

    public function yieldMonitoringsearch (Request $request)
    {

        $request->validate([
            'barangay'  => 'required',
            'year_id'   => 'required',
            'cropping_season'   => 'required',
        ]);

        
         $N_crop = Crop::pluck('name');
        ////Crops Unit Stacked Bar Chart
        for($i = 0; $i <= 12; $i++)
        {
            $chk = Farming_data::whereYear('date', '=', $request->year_id)->where('municipality_id', Auth::user()->muni_address)->where('crop_id', $i+1)->where('barangay_id', $request->barangay)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('yield','!=',NULL)->count();
            if($chk != NULL || $chk != 0 )
            {
                $U_crop[$i] = Farming_data::whereYear('date', '=', $request->year_id)->where('municipality_id', Auth::user()->muni_address)->where('crop_id', $i+1)->where('barangay_id', $request->barangay)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('yield','!=',NULL)->pluck('yield')->sum();
                $H_crop[$i] = Farming_data::whereYear('date', '=', $request->year_id)->where('municipality_id', Auth::user()->muni_address)->where('crop_id', $i+1)->where('barangay_id', $request->barangay)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('yield','!=',NULL)->pluck('lot_size')->sum();
            } else
            {
                $U_crop[$i] = 0;
                $H_crop[$i] = 0;
            }
            
        }
        
        ////Farmer Unit Stacked Bar Chart
        // Getting all farmer informttion in an array
        $F_id = Farming_data::whereYear('date', '=', $request->year_id)->where('municipality_id', Auth::user()->muni_address)->where('barangay_id', $request->barangay)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('yield','!=',NULL)->distinct('farmer_id')->pluck('farmer_id');
        //$Farmer = Farmer::whereYear('date', '=', $request->year_id)->where('municipality_id', Auth::user()->muni_address)->where('barangay_id', $request->barangay)->get();

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
            $Bitter_gourd[$i] =  number_format(Farming_data::whereYear('date', '=', $request->year_id)->where('farmer_id', $f)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 1)->sum('yield')/1000, 2);

            $Cabbage[$i]  = number_format(Farming_data::whereYear('date', '=', $request->year_id)->where('farmer_id', $f)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 2)->sum('yield')/1000, 2);

            $Corn[$i]  = number_format(Farming_data::whereYear('date', '=', $request->year_id)->where('farmer_id', $f)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 3)->sum('yield')/1000, 2);

            $Eggplant[$i]  = number_format(Farming_data::whereYear('date', '=', $request->year_id)->where('farmer_id', $f)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 4)->sum('yield')/1000, 2);

            $Garlic[$i]  = number_format(Farming_data::whereYear('date', '=', $request->year_id)->where('farmer_id', $f)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 5)->sum('yield')/1000, 2);

            $Ladys_finger[$i] = number_format(Farming_data::whereYear('date', '=', $request->year_id)->where('farmer_id', $f)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 6)->sum('yield')/1000, 2);

            $Rice[$i] = number_format(Farming_data::whereYear('date', '=', $request->year_id)->where('farmer_id', $f)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 7)->sum('yield')/1000, 2);

            $Onion[$i] = number_format(Farming_data::whereYear('date', '=', $request->year_id)->where('farmer_id', $f)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 8)->sum('yield')/1000, 2);

            $Peanut[$i] = number_format(Farming_data::whereYear('date', '=', $request->year_id)->where('farmer_id', $f)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 9)->sum('yield')/1000, 2);

            $String_bean[$i] = number_format(Farming_data::whereYear('date', '=', $request->year_id)->where('farmer_id', $f)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 10)->sum('yield')/1000, 2);

            $Tobacco[$i] = number_format(Farming_data::whereYear('date', '=', $request->year_id)->where('farmer_id', $f)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 11)->sum('yield')/1000, 2);

            $Tomato[$i] = number_format(Farming_data::whereYear('date', '=', $request->year_id)->where('farmer_id', $f)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 12)->sum('yield')/1000, 2);
            
            $Water_melon[$i] = number_format(Farming_data::whereYear('date', '=', $request->year_id)->where('farmer_id', $f)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 13)->sum('yield')/1000, 2);
            $i++;
            }
        }
    

        $n_brgy = Barangay::where('municipality_id', Auth::user()->muni_address)->get();
        
        // Getting all crop count , one by one
        $i = 0;
        $total_unit = 0;
        foreach($n_brgy as $key => $n_b)
        {
            $chk = Farming_data::whereYear('date', '=', $request->year_id)->where('status', 0)->where('yield','!=',NULL)->where('cropping_season_id', $request->cropping_season)->where('barangay_id', $n_b->id)->count();  
            
            if($chk != 0)
            {
            $Bitter_gourd_com[$i] =  number_format(Farming_data::whereYear('date', '=', $request->year_id)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 1)->where('barangay_id', $n_b->id)->sum('yield')/1000, 2);

            $Cabbage_com[$i]  = number_format(Farming_data::whereYear('date', '=', $request->year_id)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 2)->where('barangay_id', $n_b->id)->sum('yield')/1000, 2);

            $Corn_com[$i]  = number_format(Farming_data::whereYear('date', '=', $request->year_id)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 3)->where('barangay_id', $n_b->id)->sum('yield')/1000, 2);

            $Eggplant_com[$i]  = number_format(Farming_data::whereYear('date', '=', $request->year_id)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 4)->where('barangay_id', $n_b->id)->sum('yield')/1000, 2);

            $Garlic_com[$i]  = number_format(Farming_data::whereYear('date', '=', $request->year_id)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 5)->where('barangay_id', $n_b->id)->sum('yield')/1000, 2);

            $Ladys_finger_com[$i] = number_format(Farming_data::whereYear('date', '=', $request->year_id)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 6)->where('barangay_id', $n_b->id)->sum('yield')/1000, 2);

            $Rice_com[$i] = number_format(Farming_data::whereYear('date', '=', $request->year_id)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 7)->where('barangay_id', $n_b->id)->sum('yield')/1000, 2);

            $Onion_com[$i] = number_format(Farming_data::whereYear('date', '=', $request->year_id)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 8)->where('barangay_id', $n_b->id)->sum('yield')/1000, 2);

            $Peanut_com[$i] = number_format(Farming_data::whereYear('date', '=', $request->year_id)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 9)->where('barangay_id', $n_b->id)->sum('yield')/1000, 2);

            $String_bean_com[$i] = number_format(Farming_data::whereYear('date', '=', $request->year_id)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 10)->where('barangay_id', $n_b->id)->sum('yield')/1000, 2);

            $Tobacco_com[$i] = number_format(Farming_data::whereYear('date', '=', $request->year_id)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 11)->where('barangay_id', $n_b->id)->sum('yield')/1000, 2);

            $Tomato_com[$i] = number_format(Farming_data::whereYear('date', '=', $request->year_id)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 12)->where('barangay_id', $n_b->id)->sum('yield')/1000, 2);
            
            $Water_melon_com[$i] = number_format(Farming_data::whereYear('date', '=', $request->year_id)->where('cropping_season_id', $request->cropping_season)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 13)->where('barangay_id', $n_b->id)->sum('yield')/1000, 2);
            
            $name_brgy[$i] = Barangay::where('id', $n_b->id)->value('name');
            $i++;
            }
        }

        $jsbrgy = Barangay::where('id', $request->barangay)->value('name');
        $jsyear = $request->year_id;
        $jscs   = Cropping_season::where('id', $request->cropping_season)->value('name');
        $technician = Auth::user()->name;
        $muni = Municipality::where('id', Auth::user()->muni_address)->value('name');

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
            'technician'    => $technician,
            'muni'    => $muni,

            'Bitter_gourds_com'   => $Bitter_gourd_com,
            'Cabbages_com'   => $Cabbage_com,
            'Corns_com'   => $Corn_com,
            'Eggplants_com'   => $Eggplant_com,
            'Garlics_com'   => $Garlic_com,
            'Ladys_fingers_com'   => $Ladys_finger_com,
            'Rices_com'   => $Rice_com,
            'Onions_com'   => $Onion_com,
            'Peanuts_com'   => $Peanut_com,
            'String_beans_com'   => $String_bean_com,
            'Tobaccos_com'   => $Tobacco_com,
            'Tomatos_com'   => $Tomato_com,
            'Water_melons_com'   => $Water_melon_com,
            'n_brgys'   => $name_brgy

        ));
    }
}
