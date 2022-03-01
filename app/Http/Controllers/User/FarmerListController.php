<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Farming_data;
use App\Models\Farmer;
use App\Models\Municipality;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;


class FarmerListController extends Controller
{

    public function farmerList()
    {
        $municipality = DB::table("municipalities")->pluck("name","id");
        $farming_data= Farming_data::all(); 
        $farmer = Farmer::all()->where("user_id", Auth::user()->id);

        return view('user/farmerList', array('municipalities' => $municipality, 'farmers' => $farmer, 'farming_datas' => $farming_data));
    }

    public function farmerListAjax($id)
    {
        $barangays = DB::table("barangays")
                    ->where("municipality_id",$id)
                    ->pluck("name","name");
        return json_encode($barangays);
    }

    public function addFarmer(Request $request)
    {

        $request->validate([
            'name'  => 'required|unique:farmers',
            'municipality'  => 'required',
            'barangay'  => 'required',
        ]);

        $muni = DB::table("municipalities")->where("id",$request->municipality)->value('name');

        $farmer =  new Farmer();
        $farmer->name = $request->name;
        $farmer->municipality = $muni;
        $farmer->status = '1';
        $farmer->barangay = $request->barangay;
        $farmer->user_id = Auth::user()->id;
        $farmer->save();

        return back();
    }

    public function updateFarmer(Request $request, $id)
    {
        $muni = DB::table("municipalities")->where("id",$request->municipality)->value('name');
        DB::table('farmers')
            ->where('id', $id)
            ->update([
            'name' => $request->name, 
            'municipality' => $muni,
            'barangay'  => $request->barangay
            ]);
        return redirect()->route('farmerList')->with('success', 'Update Sucessfully');
    }

    public function DeleteFarmer($id)
    {
        DB::table('farmers')
            ->where('id', $id)
            ->delete();
        return redirect()->route('farmerList')->with('success', 'Update Sucessfully');
    }
}
