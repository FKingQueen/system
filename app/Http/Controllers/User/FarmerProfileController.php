<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Farmer;
use App\Models\Farming_data;

class FarmerProfileController extends Controller
{
    public function farmerProfile($id)
    {
        $farmer = Farmer::all()->where("id", $id);
        return view('user/farmerProfile', array("farmers"=> $farmer));
    }

    public function compose(Request $request, $id){
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
        $farming_data->cropping_season_id = 1; 
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
