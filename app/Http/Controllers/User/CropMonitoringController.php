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

        $farmer = Farmer::whereYear('created_at', '=', $request->year_id)->where('municipality_id', $request->municipality)->where('barangay_id', $request->barangay)->get();
        $Fcount = Farmer::whereYear('created_at', '=', $request->year_id)->where('municipality_id', $request->municipality)->where('barangay_id', $request->barangay)->count();

        for($i = 0; $i <= $Fcount-1; $i++)
        {
            $Fid[$i] = $farmer[$i]->id;
        }

        for($i = 0; $i <= $Fcount-1; $i++)
        {
            for($j = 0; $j <= 2; $j++)
            {
                if($j==0)
                {
                    $Fvalue[$i][$j] = Activity_file::where('farmer_id', $Fid[$i])->where('activity', 'water')->where('status_id', '2')->count();
                } else if($j==1)
                {
                    $Fvalue[$i][$j] = Activity_file::where('farmer_id', $Fid[$i])->where('activity', 'fertilizer')->where('status_id', '2')->count();
                } else if($j==2)
                {
                    $Fvalue[$i][$j] = Activity_file::where('farmer_id', $Fid[$i])->where('activity', 'pesticide')->where('status_id', '2')->count();
                }
            }
        }

        for($i = 0; $i <= $Fcount-1; $i++)
        {
            $count = Activity_file::where('farmer_id', $Fid[$i])->count();
            for($j = 0; $j <= 2; $j++)
            {
                if($count != 0)
                {
                    $Fpercent[$i][$j] = number_format(($Fvalue[$i][$j]/$count)*100);
                } else if($count == 0)
                {
                    $Fpercent[$i][$j] = null;
                }
                
            }
        } 
        
        $municipality = DB::table("municipalities")->pluck("name","id");
        return view('user/cropMonitoring', array("municipalities" => $municipality, "farmers" => $farmer, "Fpercents" => $Fpercent));
    }
}
