<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Farming_data;
use App\Models\Activity_file;
use App\Models\Farmer;
use App\Models\Crop;
use App\Models\Barangay;
use Illuminate\Http\Request;
use App\Models\Municipality;
use Illuminate\Support\Facades\DB;
use Validator;
use Auth;

class CropMonitoringController extends Controller
{
    public function cropMonitoring (Request $request)
    {

        $request->validate([
            'barangay'  => 'required',
        ]);

        //get farmer data in the table
        $Farmer = Farmer::whereYear('created_at', '=', 2022)->where('municipality_id', Auth::user()->muni_address)->where('barangay_id', $request->barangay)->get();
        //count the farmer
        $F_count = Farmer::whereYear('created_at', '=', 2022)->where('municipality_id', Auth::user()->muni_address)->where('barangay_id', $request->barangay)->count();
        //get all farmer IDs in the table
        $F_id = Farmer::whereYear('created_at', '=', 2022)->where('municipality_id', Auth::user()->muni_address)->where('barangay_id', $request->barangay)->pluck('id');

        //Validation if the selected options is empty, it will return back with error notification
        if($F_count == 0)
        {
             return back()->with('cropmonitorfailed', 'Failed');
        }

        //storing/getting the count of every farming activity(water, persticide, fertilizer) in array
        for($i = 0; $i <= $F_count-1; $i++)
        {
            for($j = 0; $j <= 2; $j++)
            {
                if($j==0)
                {
                    $FA_count[$i][$j] = Activity_file::where('farmer_id', $F_id[$i])->where('activity', 'water')->where('status', '0')->count();
                } else if($j==1)
                {
                    $FA_count[$i][$j] = Activity_file::where('farmer_id', $F_id[$i])->where('activity', 'fertilizer')->where('status', '0')->count();
                } else if($j==2)
                {
                    $FA_count[$i][$j] = Activity_file::where('farmer_id', $F_id[$i])->where('activity', 'pesticide')->where('status', '0')->count();
                }
            }
            if($FA_count[$i][0] == 0 && $FA_count[$i][1] == 0 && $FA_count[$i][2] == 0)
            {
                $FA_count[$i] = 0; 
            }
        }

        //storing/getting the percent of every farming activity(water, persticide, fertilizer) in array
        for($i = 0; $i <= $F_count-1; $i++)
        {
            $T_count = Activity_file::where('farmer_id', $F_id[$i])->where('status', '0')->count();
            for($j = 0; $j <= 2; $j++)
            {
                if($T_count != 0)
                {
                    $FA_percent[$i][$j] = number_format(($FA_count[$i][$j]/$T_count)*100);
                } else if($T_count == 0)
                {
                    $FA_percent[$i] = 0;
                }
            } 
        }

        

        //Validation if the selected options is empty, it will return back with error notification
        $chk = 0;
        foreach($FA_count as $key => $fa_count)
        {
            if($FA_count[$key] == 0)
            {
                $chk++;
            }
        }

        if($key == $chk-1)
        {
            return back()->with('cropmonitorfailed', 'Failed');
        }

            


        //$FD_id = Farming_data::whereYear('created_at', '=', 2022)->where('municipality_id', Auth::user()->muni_address)->where('status', '0')->where('barangay_id', $request->barangay)->value('id')->unique();
        

        //storing/getting the specific count of a crop in every farming activity(water, persticide, fertilizer) in array
        foreach($F_id as $key1 => $f)
        {
            $counter = Farming_data::whereYear('created_at', '=', 2022)->where('farmer_id', $F_id[$key1])->where('yield','!=',NULL)->where('municipality_id', Auth::user()->muni_address)->where('status', '0')->where('barangay_id', $request->barangay)->count();
            $FD_id = Farming_data::whereYear('created_at', '=', 2022)->where('farmer_id', $F_id[$key1])->where('yield','!=',NULL)->where('municipality_id', Auth::user()->muni_address)->where('status', '0')->where('barangay_id', $request->barangay)->pluck('id');
            $FD_counter[$key1] = $counter;
            for($j = 0; $j <= $counter-1; $j++ )
            {
                for($i = 0; $i <= 2; $i++)
                {
                    if($i==0)
                    {
                        $FD_count[$key1][$j][$i] = Activity_file::where('farming_data_id', $FD_id[$j])->where('activity', 'water')->where('status', '0')->count();
                    } else if($i==1)
                    {
                        $FD_count[$key1][$j][$i] = Activity_file::where('farming_data_id', $FD_id[$j])->where('activity', 'fertilizer')->where('status', '0')->count();
                    } else if($i==2)
                    {
                        $FD_count[$key1][$j][$i] = Activity_file::where('farming_data_id', $FD_id[$j])->where('activity', 'pesticide')->where('status', '0')->count();
                    }
                }
            }
        }
        

        //storing/getting the specific percent of a crop in every farming activity(water, persticide, fertilizer) in array
        foreach($F_id as $key1 => $f)
        {
            $FD_id = Farming_data::whereYear('created_at', '=', 2022)->where('yield','!=',NULL)->where('farmer_id', $F_id[$key1])->where('municipality_id', Auth::user()->muni_address)->where('status', '0')->where('barangay_id', $request->barangay)->pluck('id');
            
            foreach($FD_id as $key2 => $fd)
            {

                $T_count = Activity_file::where('farming_data_id', $fd)->where('status', '0')->count();
                for($i = 0; $i <= 2; $i++)
                {
                    $FD_percent[$key1][$key2][$i] = number_format(($FD_count[$key1][$key2][$i]/$T_count)*100);
                }
            }
            
        }


        $FD_id = Farming_data::whereYear('created_at', '=', 2022)->where('yield','!=',NULL)->where('municipality_id', Auth::user()->muni_address)->where('status', '0')->where('barangay_id', $request->barangay)->get();
        $x = 0;
        foreach($F_id as $key1 => $f)
        {
            $counter = Farming_data::whereYear('created_at', '=', 2022)->where('farmer_id', $F_id[$key1])->where('yield','!=',NULL)->where('municipality_id', Auth::user()->muni_address)->where('status', '0')->where('barangay_id', $request->barangay)->count();
            $FD_crop[$key1] = Farming_data::with('crop')->whereYear('created_at', '=', 2022)->where('farmer_id', $F_id[$key1])->where('yield','!=',NULL)->where('municipality_id', Auth::user()->muni_address)->where('status', '0')->where('barangay_id', $request->barangay)->get();
            
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

        
        

        
        $c_crop = Crop::count();



        foreach($Farmer as $key => $f)
        {

            for($i = 0; $i <= $c_crop-1; $i++)
            {         
                $crop[$key][$i] = Farming_data::where('farmer_id', $f->id)->where('crop_id', $i+1)->count();
            }
        }

        $i = 0;
        foreach($Farmer as $key => $f)
        {
            $chk = Farming_data::where('farmer_id', $f->id)->where('status', 0)->count();  
            
            if($chk != 0)
            {
            $FC_total = Farming_data::where('farmer_id', $f->id)->where('status', 0)->count();
            $Bitter_gourd[$i] = number_format((Farming_data::where('farmer_id', $f->id)->where('status', 0)->where('crop_id', 1)->count()/$FC_total)*100);
            $Cabbage[$i]  = number_format((Farming_data::where('farmer_id', $f->id)->where('status', 0)->where('crop_id', 2)->count()/$FC_total)*100);
            $Corn[$i]  = number_format((Farming_data::where('farmer_id', $f->id)->where('status', 0)->where('crop_id', 3)->count()/$FC_total)*100);
            $Eggplant[$i]  = number_format((Farming_data::where('farmer_id', $f->id)->where('status', 0)->where('crop_id', 4)->count()/$FC_total)*100);
            $Garlic[$i]  = number_format((Farming_data::where('farmer_id', $f->id)->where('status', 0)->where('crop_id', 5)->count()/$FC_total)*100);
            $Ladys_finger[$i] = number_format((Farming_data::where('farmer_id', $f->id)->where('status', 0)->where('crop_id', 6)->count()/$FC_total)*100);
            $Rice[$i] = number_format((Farming_data::where('farmer_id', $f->id)->where('status', 0)->where('crop_id', 7)->count()/$FC_total)*100);
            $Onion[$i] = number_format((Farming_data::where('farmer_id', $f->id)->where('status', 0)->where('crop_id', 8)->count()/$FC_total)*100);
            $Peanut[$i] = number_format((Farming_data::where('farmer_id', $f->id)->where('status', 0)->where('crop_id', 9)->count()/$FC_total)*100);
            $String_bean[$i] = number_format((Farming_data::where('farmer_id', $f->id)->where('status', 0)->where('crop_id', 10)->count()/$FC_total)*100);
            $Tobacco[$i] = number_format((Farming_data::where('farmer_id', $f->id)->where('status', 0)->where('crop_id', 11)->count()/$FC_total)*100);
            $Tomato[$i] = number_format((Farming_data::where('farmer_id', $f->id)->where('status', 0)->where('crop_id', 12)->count()/$FC_total)*100);
            $Water_melon[$i] = number_format((Farming_data::where('farmer_id', $f->id)->where('status', 0)->where('crop_id', 13)->count()/$FC_total)*100);
            $i++;
            }

        }
        $barangay = Barangay::where("municipality_id", Auth::user()->muni_address)->get(); 
        return view('user/cropMonitoring',  array(
            'barangays' => $barangay,
            'Farmers'   => $Farmer,
            'FA_counts' => $FA_count,
            'FA_percents' => $FA_percent,
            'FD_counts' => $FD_count,
            'FD_percents' => $FD_percent,
            'FD_counters'   => $FD_counter,
            'FD_crops'   => $FD_crop,
            'n_farmers'   => $n_farmer,
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
            'Water_melons'   => $Water_melon
        ));
    }


    public function cropMonitoring2 ()
    {
        $request->validate([
            'year_id'  => 'required',
            'barangay'  => 'required',
        ]);

        //get farmer data in the table
        $Farmer = Farmer::whereYear('created_at', '=', 2022)->where('municipality_id', Auth::user()->muni_address)->where('barangay_id', $request->barangay)->get();
        //count the farmer
        $F_count = Farmer::whereYear('created_at', '=', 2022)->where('municipality_id', Auth::user()->muni_address)->where('barangay_id', $request->barangay)->count();
        //get all farmer IDs in the table
        $F_id = Farmer::whereYear('created_at', '=', 2022)->where('municipality_id', Auth::user()->muni_address)->where('barangay_id', $request->barangay)->pluck('id');

        //Validation if the selected options is empty, it will return back with error notification
        if($F_count == 0)
        {
             return back()->with('cropmonitorfailed', 'Failed');
        }

        //storing/getting the count of every farming activity(water, persticide, fertilizer) in array
        for($i = 0; $i <= $F_count-1; $i++)
        {
            for($j = 0; $j <= 2; $j++)
            {
                if($j==0)
                {
                    $FA_count[$i][$j] = Activity_file::where('farmer_id', $F_id[$i])->where('activity', 'water')->where('status', '0')->count();
                } else if($j==1)
                {
                    $FA_count[$i][$j] = Activity_file::where('farmer_id', $F_id[$i])->where('activity', 'fertilizer')->where('status', '0')->count();
                } else if($j==2)
                {
                    $FA_count[$i][$j] = Activity_file::where('farmer_id', $F_id[$i])->where('activity', 'pesticide')->where('status', '0')->count();
                }
            }
            if($FA_count[$i][0] == 0 && $FA_count[$i][1] == 0 && $FA_count[$i][2] == 0)
            {
                $FA_count[$i] = 0; 
            }
        }

        //storing/getting the percent of every farming activity(water, persticide, fertilizer) in array
        for($i = 0; $i <= $F_count-1; $i++)
        {
            $T_count = Activity_file::where('farmer_id', $F_id[$i])->where('status', '0')->count();
            for($j = 0; $j <= 2; $j++)
            {
                if($T_count != 0)
                {
                    $FA_percent[$i][$j] = number_format(($FA_count[$i][$j]/$T_count)*100);
                } else if($T_count == 0)
                {
                    $FA_percent[$i] = 0;
                }
            } 
        }

        

        //Validation if the selected options is empty, it will return back with error notification
        $chk = 0;
        foreach($FA_count as $key => $fa_count)
        {
            if($FA_count[$key] == 0)
            {
                $chk++;
            }
        }

        if($key == $chk-1)
        {
            return back()->with('cropmonitorfailed', 'Failed');
        }

            


        //$FD_id = Farming_data::whereYear('created_at', '=', 2022)->where('municipality_id', Auth::user()->muni_address)->where('status', '0')->where('barangay_id', $request->barangay)->value('id')->unique();
        

        //storing/getting the specific count of a crop in every farming activity(water, persticide, fertilizer) in array
        foreach($F_id as $key1 => $f)
        {
            $counter = Farming_data::whereYear('created_at', '=', 2022)->where('farmer_id', $F_id[$key1])->where('yield','!=',NULL)->where('municipality_id', Auth::user()->muni_address)->where('status', '0')->where('barangay_id', $request->barangay)->count();
            $FD_id = Farming_data::whereYear('created_at', '=', 2022)->where('farmer_id', $F_id[$key1])->where('yield','!=',NULL)->where('municipality_id', Auth::user()->muni_address)->where('status', '0')->where('barangay_id', $request->barangay)->pluck('id');
            $FD_counter[$key1] = $counter;
            for($j = 0; $j <= $counter-1; $j++ )
            {
                for($i = 0; $i <= 2; $i++)
                {
                    if($i==0)
                    {
                        $FD_count[$key1][$j][$i] = Activity_file::where('farming_data_id', $FD_id[$j])->where('activity', 'water')->where('status', '0')->count();
                    } else if($i==1)
                    {
                        $FD_count[$key1][$j][$i] = Activity_file::where('farming_data_id', $FD_id[$j])->where('activity', 'fertilizer')->where('status', '0')->count();
                    } else if($i==2)
                    {
                        $FD_count[$key1][$j][$i] = Activity_file::where('farming_data_id', $FD_id[$j])->where('activity', 'pesticide')->where('status', '0')->count();
                    }
                }
            }
        }
        

        //storing/getting the specific percent of a crop in every farming activity(water, persticide, fertilizer) in array
        foreach($F_id as $key1 => $f)
        {
            $FD_id = Farming_data::whereYear('created_at', '=', 2022)->where('yield','!=',NULL)->where('farmer_id', $F_id[$key1])->where('municipality_id', Auth::user()->muni_address)->where('status', '0')->where('barangay_id', $request->barangay)->pluck('id');
            
            foreach($FD_id as $key2 => $fd)
            {

                $T_count = Activity_file::where('farming_data_id', $fd)->where('status', '0')->count();
                for($i = 0; $i <= 2; $i++)
                {
                    $FD_percent[$key1][$key2][$i] = number_format(($FD_count[$key1][$key2][$i]/$T_count)*100);
                }
            }
            
        }


        $FD_id = Farming_data::whereYear('created_at', '=', 2022)->where('yield','!=',NULL)->where('municipality_id', Auth::user()->muni_address)->where('status', '0')->where('barangay_id', $request->barangay)->get();
        $x = 0;
        foreach($F_id as $key1 => $f)
        {
            $counter = Farming_data::whereYear('created_at', '=', 2022)->where('farmer_id', $F_id[$key1])->where('yield','!=',NULL)->where('municipality_id', Auth::user()->muni_address)->where('status', '0')->where('barangay_id', $request->barangay)->count();
            $FD_crop[$key1] = Farming_data::with('crop')->whereYear('created_at', '=', 2022)->where('farmer_id', $F_id[$key1])->where('yield','!=',NULL)->where('municipality_id', Auth::user()->muni_address)->where('status', '0')->where('barangay_id', $request->barangay)->get();
            
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

        
        

        
        $c_crop = Crop::count();



        foreach($Farmer as $key => $f)
        {

            for($i = 0; $i <= $c_crop-1; $i++)
            {         
                $crop[$key][$i] = Farming_data::where('farmer_id', $f->id)->where('crop_id', $i+1)->count();
            }
        }

        $i = 0;
        foreach($Farmer as $key => $f)
        {
            $chk = Farming_data::where('farmer_id', $f->id)->where('status', 0)->count();  
            
            if($chk != 0)
            {
            $FC_total = Farming_data::where('farmer_id', $f->id)->where('status', 0)->count();
            $Bitter_gourd[$i] = number_format((Farming_data::where('farmer_id', $f->id)->where('status', 0)->where('crop_id', 1)->count()/$FC_total)*100);
            $Cabbage[$i]  = number_format((Farming_data::where('farmer_id', $f->id)->where('status', 0)->where('crop_id', 2)->count()/$FC_total)*100);
            $Corn[$i]  = number_format((Farming_data::where('farmer_id', $f->id)->where('status', 0)->where('crop_id', 3)->count()/$FC_total)*100);
            $Eggplant[$i]  = number_format((Farming_data::where('farmer_id', $f->id)->where('status', 0)->where('crop_id', 4)->count()/$FC_total)*100);
            $Garlic[$i]  = number_format((Farming_data::where('farmer_id', $f->id)->where('status', 0)->where('crop_id', 5)->count()/$FC_total)*100);
            $Ladys_finger[$i] = number_format((Farming_data::where('farmer_id', $f->id)->where('status', 0)->where('crop_id', 6)->count()/$FC_total)*100);
            $Rice[$i] = number_format((Farming_data::where('farmer_id', $f->id)->where('status', 0)->where('crop_id', 7)->count()/$FC_total)*100);
            $Onion[$i] = number_format((Farming_data::where('farmer_id', $f->id)->where('status', 0)->where('crop_id', 8)->count()/$FC_total)*100);
            $Peanut[$i] = number_format((Farming_data::where('farmer_id', $f->id)->where('status', 0)->where('crop_id', 9)->count()/$FC_total)*100);
            $String_bean[$i] = number_format((Farming_data::where('farmer_id', $f->id)->where('status', 0)->where('crop_id', 10)->count()/$FC_total)*100);
            $Tobacco[$i] = number_format((Farming_data::where('farmer_id', $f->id)->where('status', 0)->where('crop_id', 11)->count()/$FC_total)*100);
            $Tomato[$i] = number_format((Farming_data::where('farmer_id', $f->id)->where('status', 0)->where('crop_id', 12)->count()/$FC_total)*100);
            $Water_melon[$i] = number_format((Farming_data::where('farmer_id', $f->id)->where('status', 0)->where('crop_id', 13)->count()/$FC_total)*100);
            $i++;
            }

        }
        $barangay = Barangay::where("municipality_id", Auth::user()->muni_address)->get(); 
        return view('user/cropMonitoring',  array(
            'barangays' => $barangay,
            'Farmers'   => $Farmer,
            'FA_counts' => $FA_count,
            'FA_percents' => $FA_percent,
            'FD_counts' => $FD_count,
            'FD_percents' => $FD_percent,
            'FD_counters'   => $FD_counter,
            'FD_crops'   => $FD_crop,
            'n_farmers'   => $n_farmer,
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
            'Water_melons'   => $Water_melon
        ));  
    }
}
