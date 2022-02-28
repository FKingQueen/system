<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Farmer;
use App\Models\Farming_data;
use Carbon\Carbon;

class FarmerProfileController extends Controller
{
    public function farmerProfile($id)
    {
        $farmer = Farmer::all()->where("id", $id);
        $farming_data = Farming_data::with('crop', 'cropping_season', 'status')->get()->where("farmer_id", $id);
        return view('user/farmerProfile', array("farmers"=> $farmer, "farming_datas" => $farming_data));
    }

    public function compose(Request $request, $id){
        $date = Carbon::now();
        $month = $date->month;


        if($request->status_id==1){
            $request->validate([
                'crop_id'  => 'required',
                'status_id'    => 'required',
            ]);
        } 
        else if($request->status_id==2){
            $request->validate([
                'crop_id'  => 'required',
                'status_id'    => 'required',
            ]);
        }

        $farming_data = new Farming_data();
        $farming_data->crop_id = $request->crop_id;
        if(($month >= 1 && $month <= 4) || ($month >= 11 && $month <= 12 ))
        {
            $farming_data->cropping_season_id = 1; 
        } else if(($month >= 5 && $month <= 10))
        {
            $farming_data->cropping_season_id = 2; 
        }
        
        $farming_data->status_id = $request->status_id; 
        $farming_data->farmer_id = $id;
        if ($request->field_unit == 1){
            $farming_data->lot_size = $request->lot_size;
        } else if ($request->field_unit == 2){
            $farming_data->lot_size = $request->lot_size/1000;
        }
        
        if($request->status_id == 2){
            $total = ($request->sacks*$request->kg)/$farming_data->lot_size;
            $farming_data->yield = $total * (10 ** -3);
        }
        $farming_data->save();
        
        return redirect()->route('farmerProfile', [$id])->with('success', 'Update Sucessfully');
    }
}
