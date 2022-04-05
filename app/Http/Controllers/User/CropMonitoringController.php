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
            'year_id'  => 'required',
            'barangay'  => 'required',
        ]);

        //get farmer data in the table
        $Farmer = Farmer::whereYear('created_at', '=', $request->year_id)->where('municipality_id', Auth::user()->muni_address)->where('barangay_id', $request->barangay)->get();
        //count the farmer
        $F_count = Farmer::whereYear('created_at', '=', $request->year_id)->where('municipality_id', Auth::user()->muni_address)->where('barangay_id', $request->barangay)->count();
        //get all farmer IDs in the table
        $F_id = Farmer::whereYear('created_at', '=', $request->year_id)->where('municipality_id', Auth::user()->muni_address)->where('barangay_id', $request->barangay)->pluck('id');
        
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
        if($FA_count[0] == 0)
        {
                return back()->with('cropmonitorfailed', 'Failed');
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


        $FD_id = Farming_data::whereYear('created_at', '=', $request->year_id)->where('yield','!=',NULL)->where('municipality_id', Auth::user()->muni_address)->where('status', '0')->where('barangay_id', $request->barangay)->pluck('id');
        $x = 0;
        foreach($F_id as $key1 => $f)
        {
            $counter = Farming_data::whereYear('created_at', '=', $request->year_id)->where('farmer_id', $F_id[$key1])->where('yield','!=',NULL)->where('municipality_id', Auth::user()->muni_address)->where('status', '0')->where('barangay_id', $request->barangay)->count();
            for($i = 0; $i <= $counter-1; $i++)
            {
                $FD_crop[$key1][$i] = Farming_data::with('crop')->whereYear('created_at', '=', $request->year_id)->where('id', $FD_id[$x] )->where('yield','!=',NULL)->where('municipality_id', Auth::user()->muni_address)->where('status', '0')->where('barangay_id', $request->barangay)->get();
                $x++;
            }
        }

        $c_crop = Crop::count();
        $c_farmer = Farmer::whereYear('created_at', '=', $request->year_id)->where('barangay_id', $request->barangay)->count();
        
        for($i = 0; $i <= $c_farmer-1; $i++)
        {
            $n_farmer[$i] = $i+1;

        }

        foreach($Farmer as $key => $f)
        {

            for($i = 0; $i <= $c_crop-1; $i++)
            {         
                $crop[$key][$i] = Farming_data::where('farmer_id', $f->id)->where('crop_id', $i+1)->count();
            }
        }

        // dd($crop);


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
            'crops'   => $crop
        ));


        // $farmer = Farmer::whereYear('created_at', '=', $request->year_id)->where('municipality_id', Auth::user()->muni_address)->where('barangay_id', $request->barangay)->get();
        // $Fcount = Farmer::whereYear('created_at', '=', $request->year_id)->where('municipality_id', Auth::user()->muni_address)->where('barangay_id', $request->barangay)->count();
        // if($Fcount == 0)
        // {
        //      return back()->with('cropmonitorfailed', 'Failed');
        // }
        // for($i = 0; $i <= $Fcount-1; $i++)
        // {
        //     $Fid[$i] = $farmer[$i]->id;
        // }

        // for($i = 0; $i <= $Fcount-1; $i++)
        // {
        //     for($j = 0; $j <= 2; $j++)
        //     {
        //         if($j==0)
        //         {
        //             $Fvalue[$i][$j] = Activity_file::where('farmer_id', $Fid[$i])->where('activity', 'water')->where('status', '0')->count();
        //         } else if($j==1)
        //         {
        //             $Fvalue[$i][$j] = Activity_file::where('farmer_id', $Fid[$i])->where('activity', 'fertilizer')->where('status', '0')->count();
        //         } else if($j==2)
        //         {
        //             $Fvalue[$i][$j] = Activity_file::where('farmer_id', $Fid[$i])->where('activity', 'pesticide')->where('status', '0')->count();
        //         }
        //     }
        // }


        // for($i = 0; $i <= $Fcount-1; $i++)
        // {
        //     $count = Activity_file::where('farmer_id', $Fid[$i])->count();
        //     for($j = 0; $j <= 2; $j++)
        //     {
        //         if($count != 0)
        //         {
        //             $Fpercent[$i][$j] = number_format(($Fvalue[$i][$j]/$count)*100);
        //         } else if($count == 0)
        //         {
        //             $Fpercent[$i][$j] = null;
        //         }
                
        //     }

        // } 

        

        // $FDcount = Farming_data::whereYear('created_at', '=', $request->year_id)->where('municipality_id', Auth::user()->muni_address)->where('status', '0')->where('barangay_id', $request->barangay)->count();
        // $FData = Farming_data::with('crop')->whereYear('created_at', '=', $request->year_id)->where('municipality_id', Auth::user()->muni_address)->where('barangay_id', $request->barangay)->get()->sortBy('farmer_id');
       
       
        // for($i = 0; $i <= $FDcount-1; $i++)
        // {
        //     $FDid[$i] = $FData[$i]->id;
        // }
        // $xy = 0;
        // foreach($FData as $FDatas)
        // {
        //     $FDCcount[$xy] = $FDatas->crop->id;
        //     $xy++;
        // }

        
        // for($k = 0; $k <= $Fcount-1; $k++)
        // {
        //     $ccount = Farming_data::whereYear('created_at', '=', $request->year_id)->where('farmer_id', $Fid[$k])->where('municipality_id', Auth::user()->muni_address)->where('status', '0')->where('barangay_id', $request->barangay)->count();
        //     $realCount[$k] = $ccount; 
        //     for($i = 0; $i <= $ccount-1; $i++)
        //     {

        //         $total = Activity_file::where('farming_data_id', $FDid[$i])->where('status', '0')->count();

        //         for($j = 0; $j <= 2; $j++)
        //         {
                    
        //             if($j==0)
        //             {
        //                 $FDvalue[$k][$i][$j] = number_format((Activity_file::where('farming_data_id', $FDid[$i])->where('activity', 'water')->where('status', '0')->count() / $total) *100);
        //             } else if($j==1)
        //             {
        //                 $FDvalue[$k][$i][$j] = number_format((Activity_file::where('farming_data_id', $FDid[$i])->where('activity', 'fertilizer')->where('status', '0')->count() / $total) *100);
        //             } else if($j==2)
        //             {
        //                 $FDvalue[$k][$i][$j] = number_format((Activity_file::where('farming_data_id', $FDid[$i])->where('activity', 'pesticide')->where('status', '0')->count() / $total) *100);
        //             }
        //         }
        //     }
        // }

        // $y = 0;
        // for($k = 0; $k <= $Fcount-1; $k++)
        // {
        //     $x = 0;
        //     $ccount = Farming_data::whereYear('created_at', '=', $request->year_id)->where('farmer_id', $Fid[$k])->where('municipality_id', Auth::user()->muni_address)->where('status', '0')->where('barangay_id', $request->barangay)->count();
        //     while($x <= $ccount-1)
        //     {
                
        //         $FDcrop[$k][$x] = Crop::where('id', $FDCcount[$y])->value('name');
        //         $x++;
        //         $y++;
        //     }
        // }

        // dd($FDvalue);


        // return view('user/cropMonitoring', array(
        //     "farmers" => $farmer, 
        //     "Fpercents" => $Fpercent, 
        //     "realCounts" => $realCount, 
        //     "FDcrops" => $FDcrop, 
        //     "FDvalues" => $FDvalue
        // ));
    }
}
