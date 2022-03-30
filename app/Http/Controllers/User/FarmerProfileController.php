<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Farmer;
use App\Models\Farming_data;
use App\Models\Activity_file;
use App\Models\Barangay;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Imports\UsersImport;
use App\Imports\UsersUpdate;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Municipality;
use auth;

class FarmerProfileController extends Controller
{
    public function farmerProfile($id)
    {
        $farmer = Farmer::all()->where("id", $id);
        $farming_data = Farming_data::with('crop', 'cropping_season', 'status')->orderBy('status', 'asc')->get()->where("farmer_id", $id);
        $barangay = Barangay::where("municipality_id", Auth::user()->muni_address)->get();

        
        return view('user/farmerProfile', array("farmers"=> $farmer, "farming_datas" => $farming_data, "barangays" => $barangay));
    }   

    public function compose(Request $request, $id){
        $date = Carbon::now();
        $month = $date->month;

        $request->validate([
            'crop_id'  => 'required',
            'activity_file' => 'required|mimes:csv,txt',
        ]);


        $farming_data = new Farming_data();
        $farming_data->crop_id = $request->crop_id;

        if(($month >= 1 && $month <= 4) || ($month >= 11 && $month <= 12 ))
        {
            $farming_data->cropping_season_id = 1; 
        } else if(($month >= 5 && $month <= 10))
        {
            $farming_data->cropping_season_id = 2; 
        }
        
        
        $farming_data->municipality_id = Farmer::where("id", $id)->value('municipality_id');
        $farming_data->barangay_id = Farmer::where("id", $id)->value('barangay_id');; 

        $farming_data->farmer_id = $id;
        if ($request->field_unit == 1){
            $farming_data->lot_size = $request->lot_size;
        } else if ($request->field_unit == 2){
            $farming_data->lot_size = $request->lot_size/1000;
        }
        
        // if($request->status_id == 2){
        //     $total = ($request->sacks*$request->kg)/$farming_data->lot_size;
        //     $farming_data->yield = $total * (10 ** -3);
        // }
        $farming_data->status = 1;
        $farming_data->save();

        $status = 1;

        $farmer_id = $farming_data->farmer_id;

        $path = $request->file('activity_file')->getRealPath();

        Excel::import(new UsersImport($farmer_id, $farming_data->id, $status), $path);
        
        if($farming_data){
            return redirect()->route('farmerProfile', [$id])->with('createdfarming', 'Success');
        } else{
            return redirect()->route('farmerProfile', [$id])->with('createfarmingfailed', 'Failed');
        }

    }

    public function updateCrop(Request $request, $id)
    {
        $request->validate([
            'crop_id'  => 'required',
            'status_id'    => 'required',
        ]);

        $farmer_id = DB::table('farming_datas')->where('id', $id)->value('farmer_id');

        if ($request->field_unit == 1){
            $lot_size = $request->lot_size;
        } else if ($request->field_unit == 2){
            $lot_size = $request->lot_size/1000;
        }
        
        if($request->status_id == 2){
            $total = ($request->sacks*$request->kg)/$lot_size;
            $yield = $total * (10 ** -3);

            DB::table('farming_datas')
            ->where('id', $id)
            ->update([
            'yield'  => $yield,
            ]);
        }

        $res = DB::table('farming_datas')
            ->where('id', $id)
            ->update([
            'crop_id' => $request->crop_id, 
            'status_id' => $request->status_id,
            'lot_size'  => $lot_size,
            ]);

        if($res){
            return redirect()->route('farmerProfile', [$farmer_id])->with('updatedfarming', 'Success');
        } else{
            return redirect()->route('farmerProfile', [$farmer_id])->with('updatefarmingfailed', 'Failed');
        }

    }

    public function deleteCrop ($id)
    {
        $farmer_id = DB::table('farming_datas')->where('id', $id)->value('farmer_id');

        $res = DB::table('farming_datas')
        ->where('id', $id)
        ->delete();

        if($res){
            return redirect()->route('farmerProfile', [$farmer_id])->with('deletedfarming', 'Success');
        } else{
            return redirect()->route('farmerProfile', [$farmer_id])->with('deletefarmingfailed', 'Failed');
        }

        
    }

    public function uploadActivity (Request $request, $id)
    {
        $request->validate([
            'status_id'    => 'required',
            'activity_file' => 'required|mimes:csv,txt',
        ]);

        $farmer_id = DB::table('farming_datas')->where('id', $id)->value('farmer_id');
        $lot_size = DB::table('farming_datas')->where('id', $id)->value('lot_size');

        if($request->status_id == 2){
            $total = ($request->sacks*$request->kg)/$lot_size;
            $yield = $total * (10 ** -3);

            DB::table('farming_datas')
            ->where('id', $id)
            ->update([
            'yield'  => $yield,
            ]);
        }

        $res = DB::table('farming_datas')
            ->where('id', $id)
            ->update([
            'status_id' => $request->status_id,
            ]);

        $status_id = $request->status_id;
        $farmer_id = Farming_data::where('id', $id)->value('farmer_id');

        
        $path = $request->file('activity_file')->getRealPath();

        Excel::import(new UsersUpdate($id, $status_id, $farmer_id), $path);

        if($res){
            return redirect()->route('farmerProfile', [$farmer_id])->with('uploadedfarming', 'Success');
        } else{
            return redirect()->route('farmerProfile', [$farmer_id])->with('uploadfarmingfailed', 'Failed');
        }

        
    }

    public function changeStatus(Request $request)
    {
        $farming_data = Farming_data::find($request->id);
        $farming_data->status = $request->status;
        $farming_data->save();

        DB::table('activity_files')
            ->where('farming_data_id', $request->id)
            ->update([
            'status' => $request->status,
            ]);


        return response()->json(['success'=>'Status change successfully.']);
    } 

}
