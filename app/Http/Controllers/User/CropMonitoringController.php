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

        
       
        //count the farmer
        // $F_count = Farmer::where('municipality_id', Auth::user()->muni_address)->where('barangay_id', $request->barangay)->where('status', 1)->count();
        $F_count =  Farming_data::whereYear('created_at', '=', 2022)->where('municipality_id', Auth::user()->muni_address)->where('barangay_id', $request->barangay)->where('status', 0)->where('yield','!=',NULL)->distinct('farmer_id')->count();
        //get all farmer IDs in the table
        // $F_id = Farmer::where('municipality_id', Auth::user()->muni_address)->where('barangay_id', $request->barangay)->where('status', 1)->pluck('id');
        $F_id = Farming_data::whereYear('created_at', '=', 2022)->where('municipality_id', Auth::user()->muni_address)->where('barangay_id', $request->barangay)->where('status', 0)->where('yield', '!=', NULL)->distinct('farmer_id')->pluck('farmer_id');

        if($F_id->isEmpty())
        {
            return back()->with('cropmonitorfailed', 'Failed');
        }
        //get farmer name in the table
        foreach($F_id as $key1 => $f)
        {
            $Farmer[$key1] = Farmer::where('id', $f)->value('name');
        }
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
                    $FA_percent[$i][$j] = number_format(($FA_count[$i][$j]/$T_count)*100, 2);
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
            $FD_hectare[$key1] = Farming_data::whereYear('created_at', '=', 2022)->where('farmer_id', $F_id[$key1])->where('yield','!=',NULL)->where('municipality_id', Auth::user()->muni_address)->where('status', '0')->where('barangay_id', $request->barangay)->pluck('lot_size');
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
                    $FD_percent[$key1][$key2][$i] = number_format(($FD_count[$key1][$key2][$i]/$T_count)*100, 2);
                }
            }
            
        }


        $FD_id = Farming_data::whereYear('created_at', '=', 2022)->where('yield','!=',NULL)->where('municipality_id', Auth::user()->muni_address)->where('status', '0')->where('barangay_id', $request->barangay)->get();

        foreach($F_id as $key1 => $f)
        {
            $counter = Farming_data::whereYear('created_at', '=', 2022)->where('farmer_id', $F_id[$key1])->where('yield','!=',NULL)->where('municipality_id', Auth::user()->muni_address)->where('status', '0')->where('barangay_id', $request->barangay)->count();
            $FD_crop[$key1] = Farming_data::with('crop')->whereYear('created_at', '=', 2022)->where('farmer_id', $F_id[$key1])->where('yield','!=',NULL)->where('municipality_id', Auth::user()->muni_address)->where('status', '0')->where('barangay_id', $request->barangay)->get();
            
        }
        
        $i = 0;
        foreach($F_id as $key1 => $fars)
        {
            $chk = Farming_data::where('farmer_id', $fars)->where('status', 0)->count();
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

        foreach($F_id as $key => $f)
        {

            for($i = 0; $i <= $c_crop-1; $i++)
            {         
                $crop[$key][$i] = Farming_data::where('farmer_id', $f)->where('crop_id', $i+1)->count();
            }
        }
        $i = 0;
        foreach($F_id as $key => $f)
        {
            $chk = Farming_data::whereYear('created_at', '=', 2022)->where('farmer_id', $f)->where('status', 0)->where('yield','!=',NULL)->count();  
            
            if($chk != 0)
            {
                $FC_total = Farming_data::whereYear('created_at', '=', 2022)->where('farmer_id', $f)->where('status', 0)->where('yield','!=',NULL)->count();

                if(number_format((Farming_data::whereYear('created_at', '=', 2022)->where('farmer_id', $f)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 1)->count()/$FC_total)*100) != 0)
                {
                    $Bitter_gourd[$i] = number_format((Farming_data::whereYear('created_at', '=', 2022)->where('farmer_id', $f)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 1)->count()/$FC_total)*100, 2);
                } else 
                {
                    $Bitter_gourd[$i] = NULL;
                }

                if(number_format((Farming_data::whereYear('created_at', '=', 2022)->where('farmer_id', $f)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 2)->count()/$FC_total)*100) != 0)
                {
                    $Cabbage[$i]  = number_format((Farming_data::whereYear('created_at', '=', 2022)->where('farmer_id', $f)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 2)->count()/$FC_total)*100, 2);
                } else 
                {
                    $Cabbage[$i] = NULL;
                }

                if(number_format((Farming_data::whereYear('created_at', '=', 2022)->where('farmer_id', $f)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 3)->count()/$FC_total)*100) != 0)
                {
                    $Corn[$i]  = number_format((Farming_data::whereYear('created_at', '=', 2022)->where('farmer_id', $f)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 3)->count()/$FC_total)*100, 2);
                } else 
                {
                    $Corn[$i] = NULL;
                }

                if(number_format((Farming_data::whereYear('created_at', '=', 2022)->where('farmer_id', $f)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 4)->count()/$FC_total)*100) != 0)
                {
                    $Eggplant[$i]  = number_format((Farming_data::whereYear('created_at', '=', 2022)->where('farmer_id', $f)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 4)->count()/$FC_total)*100, 2);
                } else 
                {
                    $Eggplant[$i] = NULL;
                }
                

                if(number_format((Farming_data::whereYear('created_at', '=', 2022)->where('farmer_id', $f)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 5)->count()/$FC_total)*100) != 0)
                {
                    $Garlic[$i]  = number_format((Farming_data::whereYear('created_at', '=', 2022)->where('farmer_id', $f)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 5)->count()/$FC_total)*100, 2);
                } else 
                {
                    $Garlic[$i] = NULL;
                }

                if(number_format((Farming_data::whereYear('created_at', '=', 2022)->where('farmer_id', $f)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 6)->count()/$FC_total)*100) != 0)
                {
                    $Ladys_finger[$i] = number_format((Farming_data::whereYear('created_at', '=', 2022)->where('farmer_id', $f)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 6)->count()/$FC_total)*100, 2);
                } else 
                {
                    $Ladys_finger[$i] = NULL;
                }

                if(number_format((Farming_data::whereYear('created_at', '=', 2022)->where('farmer_id', $f)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 7)->count()/$FC_total)*100) != 0)
                {
                    $Rice[$i] = number_format((Farming_data::whereYear('created_at', '=', 2022)->where('farmer_id', $f)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 7)->count()/$FC_total)*100, 2);
                } else 
                {
                    $Rice[$i] = NULL;
                }
                
                if(number_format((Farming_data::whereYear('created_at', '=', 2022)->where('farmer_id', $f)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 8)->count()/$FC_total)*100) != 0)
                {
                    $Onion[$i] = number_format((Farming_data::whereYear('created_at', '=', 2022)->where('farmer_id', $f)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 8)->count()/$FC_total)*100, 2);
                } else 
                {
                    $Onion[$i] = NULL;
                }

                if(number_format((Farming_data::whereYear('created_at', '=', 2022)->where('farmer_id', $f)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 9)->count()/$FC_total)*100) != 0)
                {
                    $Peanut[$i] = number_format((Farming_data::whereYear('created_at', '=', 2022)->where('farmer_id', $f)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 9)->count()/$FC_total)*100, 2);
                } else 
                {
                    $Peanut[$i] = NULL;
                }

                if(number_format((Farming_data::whereYear('created_at', '=', 2022)->where('farmer_id', $f)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 10)->count()/$FC_total)*100) != 0)
                {
                    $String_bean[$i] = number_format((Farming_data::whereYear('created_at', '=', 2022)->where('farmer_id', $f)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 10)->count()/$FC_total)*100, 2);
                } else 
                {
                    $String_bean[$i] = NULL;
                }

                if(number_format((Farming_data::whereYear('created_at', '=', 2022)->where('farmer_id', $f)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 11)->count()/$FC_total)*100) != 0)
                {
                    $Tobacco[$i] = number_format((Farming_data::whereYear('created_at', '=', 2022)->where('farmer_id', $f)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 11)->count()/$FC_total)*100, 2);
                } else 
                {
                    $Tobacco[$i] = NULL;
                }

                if(number_format((Farming_data::whereYear('created_at', '=', 2022)->where('farmer_id', $f)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 12)->count()/$FC_total)*100) != 0)
                {
                    $Tomato[$i] = number_format((Farming_data::whereYear('created_at', '=', 2022)->where('farmer_id', $f)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 12)->count()/$FC_total)*100, 2);
                } else 
                {
                    $Tomato[$i] = NULL;
                }

                if(number_format((Farming_data::whereYear('created_at', '=', 2022)->where('farmer_id', $f)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 12)->count()/$FC_total)*100) != 0)
                {
                    $Tomato[$i] = number_format((Farming_data::whereYear('created_at', '=', 2022)->where('farmer_id', $f)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 12)->count()/$FC_total)*100, 2);
                } else 
                {
                    $Tomato[$i] = NULL;
                }
                
                if(number_format((Farming_data::whereYear('created_at', '=', 2022)->where('farmer_id', $f)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 13)->count()/$FC_total)*100) != 0)
                {
                    $Water_melon[$i] = number_format((Farming_data::whereYear('created_at', '=', 2022)->where('farmer_id', $f)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 13)->count()/$FC_total)*100, 2);
                } else 
                {
                    $Water_melon[$i] = NULL;
                }
            
            $i++;
            }
        }

        $i = 0;
        foreach($F_id as $key => $f)
        {
            $chk = Farming_data::where('farmer_id', $f)->where('status', 0)->where('yield','!=',NULL)->count(); 
            if($chk != 0)
            {
                $N_crop[$i] = Farming_data::whereYear('created_at', '=', 2022)->where('farmer_id', $f)->where('status', 0)->where('yield','!=',NULL)->count(); 
                $i++;
            } 
            
        }

        $brgy = Barangay::where("id", $request->barangay)->value('name'); 
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
            'Water_melons'   => $Water_melon,
            'N_crops'    => $N_crop,
            'FD_hectares'    => $FD_hectare,
            'brgy'  => $brgy
        ));
    }


    public function cropMonitoringsearch (Request $request)
    {
        $request->validate([
            'year_id'  => 'required',
            'barangay'  => 'required',
        ]);

        
        //count the farmer
        $F_count =  Farming_data::whereYear('created_at', '=', $request->year_id)->where('municipality_id', Auth::user()->muni_address)->where('barangay_id', $request->barangay)->where('status', 0)->where('yield','!=',NULL)->distinct('farmer_id')->count();
        //get all farmer IDs in the table
        $F_id =  Farming_data::whereYear('created_at', '=', $request->year_id)->where('municipality_id', Auth::user()->muni_address)->where('barangay_id', $request->barangay)->where('status', 0)->where('yield','!=',NULL)->distinct('farmer_id')->pluck('farmer_id');

        //get farmer name in the table
        foreach($F_id as $key1 => $f)
        {
            $Farmer[$key1] = Farmer::where('id', $f)->value('name');
        }

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
            


        //$FD_id = Farming_data::whereYear('created_at', '=', $request->year_id)->where('municipality_id', Auth::user()->muni_address)->where('status', '0')->where('barangay_id', $request->barangay)->value('id')->unique();
        

        //storing/getting the specific count of a crop in every farming activity(water, persticide, fertilizer) in array
        foreach($F_id as $key1 => $f)
        {
            $counter = Farming_data::whereYear('created_at', '=', $request->year_id)->where('farmer_id', $F_id[$key1])->where('yield','!=',NULL)->where('municipality_id', Auth::user()->muni_address)->where('status', '0')->where('barangay_id', $request->barangay)->count();
            $FD_id = Farming_data::whereYear('created_at', '=', $request->year_id)->where('farmer_id', $F_id[$key1])->where('yield','!=',NULL)->where('municipality_id', Auth::user()->muni_address)->where('status', '0')->where('barangay_id', $request->barangay)->pluck('id');
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
            $FD_hectare[$key1] = Farming_data::whereYear('created_at', '=', $request->year_id)->where('farmer_id', $F_id[$key1])->where('yield','!=',NULL)->where('municipality_id', Auth::user()->muni_address)->where('status', '0')->where('barangay_id', $request->barangay)->pluck('lot_size');
        }
        

        //storing/getting the specific percent of a crop in every farming activity(water, persticide, fertilizer) in array
        foreach($F_id as $key1 => $f)
        {
            $FD_id = Farming_data::whereYear('created_at', '=', $request->year_id)->where('yield','!=',NULL)->where('farmer_id', $F_id[$key1])->where('municipality_id', Auth::user()->muni_address)->where('status', '0')->where('barangay_id', $request->barangay)->pluck('id');
            
            foreach($FD_id as $key2 => $fd)
            {

                $T_count = Activity_file::where('farming_data_id', $fd)->where('status', '0')->count();
                for($i = 0; $i <= 2; $i++)
                {
                    $FD_percent[$key1][$key2][$i] = number_format(($FD_count[$key1][$key2][$i]/$T_count)*100);
                }
            }
            
        }


        $FD_id = Farming_data::whereYear('created_at', '=', $request->year_id)->where('yield','!=',NULL)->where('municipality_id', Auth::user()->muni_address)->where('status', '0')->where('barangay_id', $request->barangay)->get();
        
        $x = 0;
        foreach($F_id as $key1 => $f)
        {
            $counter = Farming_data::whereYear('created_at', '=', $request->year_id)->where('farmer_id', $F_id[$key1])->where('yield','!=',NULL)->where('municipality_id', Auth::user()->muni_address)->where('status', '0')->where('barangay_id', $request->barangay)->count();
            $FD_crop[$key1] = Farming_data::with('crop')->whereYear('created_at', '=', $request->year_id)->where('farmer_id', $F_id[$key1])->where('yield','!=',NULL)->where('municipality_id', Auth::user()->muni_address)->where('status', '0')->where('barangay_id', $request->barangay)->get();
            
        }
        
        $i = 0;
        foreach($F_id as $key1 => $fars)
        {
            $chk = Farming_data::where('farmer_id', $fars)->where('status', 0)->count();
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



        foreach($F_id as $key => $f)
        {

            for($i = 0; $i <= $c_crop-1; $i++)
            {         
                $crop[$key][$i] = Farming_data::where('farmer_id', $f)->where('crop_id', $i+1)->count();
            }
        }
        
        $i = 0;
        foreach($F_id as $key => $f)
        {
            $chk = Farming_data::whereYear('created_at', '=', $request->year_id)->where('farmer_id', $f)->where('status', 0)->where('yield','!=',NULL)->count();  
            
            if($chk != 0)
            {
            $FC_total = Farming_data::whereYear('created_at', '=', $request->year_id)->where('farmer_id', $f)->where('status', 0)->where('yield','!=',NULL)->count();
            if(number_format((Farming_data::whereYear('created_at', '=', $request->year_id)->where('farmer_id', $f)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 1)->count()/$FC_total)*100) != 0)
            {
                $Bitter_gourd[$i] = number_format((Farming_data::whereYear('created_at', '=', $request->year_id)->where('farmer_id', $f)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 1)->count()/$FC_total)*100, 2);
            } else 
            {
                $Bitter_gourd[$i] = NULL;
            }

            if(number_format((Farming_data::whereYear('created_at', '=', $request->year_id)->where('farmer_id', $f)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 2)->count()/$FC_total)*100) != 0)
            {
                $Cabbage[$i]  = number_format((Farming_data::whereYear('created_at', '=', $request->year_id)->where('farmer_id', $f)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 2)->count()/$FC_total)*100, 2);
            } else 
            {
                $Cabbage[$i] = NULL;
            }

            if(number_format((Farming_data::whereYear('created_at', '=', $request->year_id)->where('farmer_id', $f)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 3)->count()/$FC_total)*100) != 0)
            {
                $Corn[$i]  = number_format((Farming_data::whereYear('created_at', '=', $request->year_id)->where('farmer_id', $f)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 3)->count()/$FC_total)*100, 2);
            } else 
            {
                $Corn[$i] = NULL;
            }

            if(number_format((Farming_data::whereYear('created_at', '=', $request->year_id)->where('farmer_id', $f)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 4)->count()/$FC_total)*100) != 0)
            {
                $Eggplant[$i]  = number_format((Farming_data::whereYear('created_at', '=', $request->year_id)->where('farmer_id', $f)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 4)->count()/$FC_total)*100, 2);
            } else 
            {
                $Eggplant[$i] = NULL;
            }

            if(number_format((Farming_data::whereYear('created_at', '=', $request->year_id)->where('farmer_id', $f)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 5)->count()/$FC_total)*100) != 0)
            {
                $Garlic[$i]  = number_format((Farming_data::whereYear('created_at', '=', $request->year_id)->where('farmer_id', $f)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 5)->count()/$FC_total)*100, 2);
            } else 
            {
                $Garlic[$i] = NULL;
            }

            if(number_format((Farming_data::whereYear('created_at', '=', $request->year_id)->where('farmer_id', $f)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 6)->count()/$FC_total)*100) != 0)
            {
                $Ladys_finger[$i] = number_format((Farming_data::whereYear('created_at', '=', $request->year_id)->where('farmer_id', $f)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 6)->count()/$FC_total)*100, 2);
            } else 
            {
                $Ladys_finger[$i] = NULL;
            }

            if(number_format((Farming_data::whereYear('created_at', '=', $request->year_id)->where('farmer_id', $f)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 7)->count()/$FC_total)*100) != 0)
            {
                $Rice[$i] = number_format((Farming_data::whereYear('created_at', '=', $request->year_id)->where('farmer_id', $f)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 7)->count()/$FC_total)*100, 2);
            } else 
            {
                $Rice[$i] = NULL;
            }
            
            if(number_format((Farming_data::whereYear('created_at', '=', $request->year_id)->where('farmer_id', $f)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 8)->count()/$FC_total)*100) != 0)
            {
                $Onion[$i] = number_format((Farming_data::whereYear('created_at', '=', $request->year_id)->where('farmer_id', $f)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 8)->count()/$FC_total)*100, 2);
            } else 
            {
                $Onion[$i] = NULL;
            }

            if(number_format((Farming_data::whereYear('created_at', '=', $request->year_id)->where('farmer_id', $f)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 9)->count()/$FC_total)*100) != 0)
            {
                $Peanut[$i] = number_format((Farming_data::whereYear('created_at', '=', $request->year_id)->where('farmer_id', $f)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 9)->count()/$FC_total)*100, 2);
            } else 
            {
                $Peanut[$i] = NULL;
            }

            if(number_format((Farming_data::whereYear('created_at', '=', $request->year_id)->where('farmer_id', $f)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 10)->count()/$FC_total)*100) != 0)
            {
                $String_bean[$i] = number_format((Farming_data::whereYear('created_at', '=', $request->year_id)->where('farmer_id', $f)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 10)->count()/$FC_total)*100, 2);
            } else 
            {
                $String_bean[$i] = NULL;
            }

            if(number_format((Farming_data::whereYear('created_at', '=', $request->year_id)->where('farmer_id', $f)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 11)->count()/$FC_total)*100) != 0)
            {
                $Tobacco[$i] = number_format((Farming_data::whereYear('created_at', '=', $request->year_id)->where('farmer_id', $f)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 11)->count()/$FC_total)*100, 2);
            } else 
            {
                $Tobacco[$i] = NULL;
            }

            if(number_format((Farming_data::whereYear('created_at', '=', $request->year_id)->where('farmer_id', $f)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 12)->count()/$FC_total)*100) != 0)
            {
                $Tomato[$i] = number_format((Farming_data::whereYear('created_at', '=', $request->year_id)->where('farmer_id', $f)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 12)->count()/$FC_total)*100, 2);
            } else 
            {
                $Tomato[$i] = NULL;
            }

            if(number_format((Farming_data::whereYear('created_at', '=', $request->year_id)->where('farmer_id', $f)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 12)->count()/$FC_total)*100) != 0)
            {
                $Tomato[$i] = number_format((Farming_data::whereYear('created_at', '=', $request->year_id)->where('farmer_id', $f)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 12)->count()/$FC_total)*100, 2);
            } else 
            {
                $Tomato[$i] = NULL;
            }
            
            if(number_format((Farming_data::whereYear('created_at', '=', $request->year_id)->where('farmer_id', $f)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 13)->count()/$FC_total)*100) != 0)
            {
                $Water_melon[$i] = number_format((Farming_data::whereYear('created_at', '=', $request->year_id)->where('farmer_id', $f)->where('status', 0)->where('yield','!=',NULL)->where('crop_id', 13)->count()/$FC_total)*100, 2);
            } else 
            {
                $Water_melon[$i] = NULL;
            }
            
            $i++;
            }
        }

        

        $i = 0;
        foreach($F_id as $key => $f)
        {
            $chk = Farming_data::where('farmer_id', $f)->where('status', 0)->where('yield','!=',NULL)->count(); 
            if($chk != 0)
            {
                $N_crop[$i] = Farming_data::whereYear('created_at', '=', $request->year_id)->where('farmer_id', $f)->where('status', 0)->where('yield','!=',NULL)->count(); 
                $i++;
            } 
            
        }
        $brgy = Barangay::where("id", $request->barangay)->value('name'); 
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
            'Water_melons'   => $Water_melon,
            'N_crops'   => $N_crop,
            'FD_hectares'    => $FD_hectare,
            'brgy'  => $brgy
        ));  
    }
}
