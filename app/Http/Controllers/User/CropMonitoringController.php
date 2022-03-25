<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Farming_data;
use App\Models\Activity_file;
use App\Models\Farmer;
use App\Models\Crop;
use Illuminate\Http\Request;
use App\Models\Municipality;
use Illuminate\Support\Facades\DB;
use Validator;

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
        if($Fcount == 0)
        {
             return back()->with('cropmonitorfailed', 'Failed');
        }
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

        

        $FDcount = Farming_data::whereYear('created_at', '=', $request->year_id)->where('municipality_id', $request->municipality)->where('status_id', '2')->where('barangay_id', $request->barangay)->count();
        $FData = Farming_data::with('crop')->whereYear('created_at', '=', $request->year_id)->where('municipality_id', $request->municipality)->where('barangay_id', $request->barangay)->get()->sortBy('farmer_id');
       
       
        for($i = 0; $i <= $FDcount-1; $i++)
        {
            $FDid[$i] = $FData[$i]->id;
        }
        $xy = 0;
        foreach($FData as $FDatas)
        {
            $FDCcount[$xy] = $FDatas->crop->id;
            $xy++;
        }

        
        for($k = 0; $k <= $Fcount-1; $k++)
        {
            $ccount = Farming_data::whereYear('created_at', '=', $request->year_id)->where('farmer_id', $Fid[$k])->where('municipality_id', $request->municipality)->where('status_id', '2')->where('barangay_id', $request->barangay)->count();
            $realCount[$k] = $ccount; 
            for($i = 0; $i <= $ccount-1; $i++)
            {

                $total = Activity_file::where('farming_data_id', $FDid[$i])->where('status_id', '2')->count();

                for($j = 0; $j <= 2; $j++)
                {
                    
                    if($j==0)
                    {
                        $FDvalue[$k][$i][$j] = number_format((Activity_file::where('farming_data_id', $FDid[$i])->where('activity', 'water')->where('status_id', '2')->count() / $total) *100);
                    } else if($j==1)
                    {
                        $FDvalue[$k][$i][$j] = number_format((Activity_file::where('farming_data_id', $FDid[$i])->where('activity', 'fertilizer')->where('status_id', '2')->count() / $total) *100);
                    } else if($j==2)
                    {
                        $FDvalue[$k][$i][$j] = number_format((Activity_file::where('farming_data_id', $FDid[$i])->where('activity', 'pesticide')->where('status_id', '2')->count() / $total) *100);
                    }
                }
            }
        }

        $y = 0;
        for($k = 0; $k <= $Fcount-1; $k++)
        {
            $x = 0;
            $ccount = Farming_data::whereYear('created_at', '=', $request->year_id)->where('farmer_id', $Fid[$k])->where('municipality_id', $request->municipality)->where('status_id', '2')->where('barangay_id', $request->barangay)->count();
            while($x <= $ccount-1)
            {
                
                $FDcrop[$k][$x] = Crop::where('id', $FDCcount[$y])->value('name');
                $x++;
                $y++;
            }
        } 

        $crops = Crop::count();

        for($i = 0; $i <= $crops-1; $i++)
        {
            $cropC[$i] = Farming_data::whereYear('created_at', '=', $request->year_id)->where('status_id', '2')->where('municipality_id', $request->municipality)->where('crop_id', $i+1)->count();
        }

      

        
        $municipality = DB::table("municipalities")->pluck("name","id");
        return view('user/cropMonitoring', array("municipalities" => $municipality, "farmers" => $farmer, "Fpercents" => $Fpercent, "realCounts" => $realCount, "FDcrops" => $FDcrop, "FDvalues" => $FDvalue, "cropCs" => $cropC));
    }
}
