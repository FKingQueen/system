<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Farmer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class FarmerListController extends Controller
{

    public function farmerList()
    {
        $municipalities = DB::table("municipalities")->pluck("name","id");

        return view('user/farmerList',compact('municipalities'));
    }

    public function farmerListAjax($id)
    {
        $barangays = DB::table("barangays")
                    ->where("municipality_id",$id)
                    ->pluck("name","id");
        return json_encode($barangays);
    }

    public function addFarmer(Request $request, $id)
    {

        $request->validate([
            'name'  => 'required|unique:farmers',
            'municipality'  => 'required',
            'barangay'  => 'required',
        ]);

        $farmer =  new Farmer();
        $farmer->name = $request->name;
        $farmer->municipality = $request->municipality;
        $farmer->barangay = $request->barangay;
        $farmer->user_id = $id;
        $farmer->save();

        return view('user/farmerList');
    }
}
