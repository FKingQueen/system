<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Farming_data;
use App\Models\Activity_file;
use App\Models\Farmer;
use Illuminate\Http\Request;
use App\Models\Municipality;
use Illuminate\Support\Facades\DB;

class CropMonitoringController extends Controller
{
    public function cropMonitoring (Request $request)
    {
        $request->validate([
            'year_id'  => 'required',
            'municipality'  => 'required',
            'barangay'  => 'required',

        ]);

        $farmer = Farmer::where('municipality_id', $request->municipality)->where('barangay_id', $request->barangay)->get();
        $count = Farming_data::all()->count();


        foreach($farmer as $key => $farmers){
            $farming_data[$key] = Farming_data::whereYear('created_at', '=', $request->year_id)->where('farmer_id', $farmers->id)->value('id');
        }


        foreach($farming_data as $key => $farming_datas){
            $count = Farming_data::where('id', $farming_data[$key])->count();
            dd($count); 
            for($i = 0; $i <= 2; $i++)
            {
                
                    $fwater[$i] = Activity_file::where('farming_data_id', $farming_data[$key])->where('activity', 'water')->count();
                    $ffertilizer[$i] = Activity_file::where('farming_data_id', $farming_data[$key])->where('activity', 'fertilizer')->count();
                    $fpesticide[$i] = Activity_file::where('farming_data_id', $farming_data[$key])->where('activity', 'pesticide')->count();
                
            }
        }

           
        

        foreach($farming_data as $key => $farming_datas){
            for($i = 0; $i <= $count-1; $i++)
            {
                $tactivity[$i] = Activity_file::where('farming_data_id', $farming_data[$key])->count();
            }
        }

        


        for($i = 0; $i <= $count-1; $i++)
            {
                {
                    $pwater[$i] = ($fwater[$i]/$tactivity[$i])*100;
                    $pfertilizer[$i] = ($ffertilizer[$i]/$tactivity[$i])*100;
                    $ppesticide[$i] = ($fpesticide[$i]/$tactivity[$i])*100;
                }
            }
        
        // foreach($farmer as $key => $farmers){
        //     for($i = 0; $i <= $count-1; $i++)
        //     {
        //             $fwater[$i] = Activity_file::where('farming_data_id', $farming_data[$key])->where('activity', 'water')->count();
        //             $ffertilizer[$i] = Activity_file::where('farming_data_id', $farming_data[$key])->where('activity', 'fertilizer')->count();
        //             $fpesticide[$i] = Activity_file::where('farming_data_id', $farming_data[$key])->where('activity', 'pesticide')->count();
        //     }
        // }

        // foreach($farmer as $key => $farmers){
        //     for($i = 0; $i <= $count-1; $i++)
        //     {
        //         $tactivity[$i] = Activity_file::where('farming_data_id', $farming_data[$key])->count();
        //     }
        // }


        // foreach($farmer as $key => $farmers){
        //     for($i = 0; $i <= $count-1; $i++)
        //         {
        //             
        //             
        //                 $pwater[$key][$i] = ($fwater[$i]/$tactivity[$i])*100;
        //                 $pfertilizer[$key][$i] = ($ffertilizer[$i]/$tactivity[$i])*100;
        //                 $ppesticide[$key][$i] = ($fpesticide[$i]/$tactivity[$i])*100;
        //             
        //         }
        // }
        
        
        $municipality = DB::table("municipalities")->pluck("name","id");
        return view('user/cropMonitoring', array("municipalities" => $municipality, "farmers" => $farmer, "pwaters" => $pwater, "pfertilizers" => $pfertilizer, "ppesticides" => $ppesticide));
    }
}
