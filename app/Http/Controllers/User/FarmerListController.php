<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Farming_data;
use App\Models\Farmer;
use App\Models\Activity_files;
use App\Models\Municipality;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;


class FarmerListController extends Controller
{

    public function farmerList()
    {
        $municipality = DB::table("municipalities")->pluck("name","id");
        $farming_data = Farming_data::all(); 
        $farmer = Farmer::with('barangays')->get()->where("user_id", Auth::user()->id);

        foreach($farmer as $farmers)
        {
            $chk = Farming_data::get()->where("farmer_id", $farmers->id)->where("status_id", 1)->count();
            if($chk == 0 || $chk == null)
            {
                DB::table('farmers')
                    ->where('id', $farmers->id)
                    ->update([
                    'status' => 2, 
                ]);
            } else if($chk != 0)
            {
                DB::table('farmers')
                    ->where('id', $farmers->id)
                    ->update([
                    'status' => 1, 
                ]);
            }
        }

        $farmer = Farmer::with('barangays')->orderBy('status', 'asc')->get()->where("user_id", Auth::user()->id);

        return view('user/farmerList', array('municipalities' => $municipality, 'farmers' => $farmer, 'farming_datas' => $farming_data));
    }

    public function farmerListAjax($id)
    {
        $barangays = DB::table("barangays")
                    ->where("municipality_id",$id)
                    ->pluck("name","id");
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
        $farmer->municipality_id = $request->municipality;
        $farmer->barangay_id = $request->barangay;
        $farmer->municipality = $muni;
        $farmer->status = '2';
        $farmer->barangay = $request->barangay;
        $farmer->user_id = Auth::user()->id;
        $farmer->save();

        if($farmer){
            return back()->with('createdfarmer', 'Success');
        } else{
            return back()->with('createfarmerfailed', 'Failed');
        }
    }

    public function updateFarmer(Request $request, $id)
    {
        $muni = DB::table("municipalities")->where("id",$request->municipality)->value('name');
        $res = DB::table('farmers')
            ->where('id', $id)
            ->update([
            'name' => $request->name, 
            'municipality' => $muni,
            'municipality_id' => $request->municipality,
            'barangay'  => $request->barangay
            ]);


        if($res){
            return redirect()->route('farmerList')->with('updatedfarmer', 'Updated');
        } else{
            return redirect()->route('farmerList')->with('updatefarmerfailed', 'Failed');
        }
    }

    public function DeleteFarmer($id)
    {
        $res = DB::table('farmers')
            ->where('id', $id)
            ->delete();

        if($res)
        {
            DB::table('farming_datas')
            ->where('farmer_id', $id)
            ->delete();
    
            DB::table('activity_files')
            ->where('farmer_id', $id)
            ->delete();
        }

        if($res){
            return redirect()->route('farmerList')->with('deletedfarmer', 'Deleted');
        } else{
            return redirect()->route('farmerList')->with('deletefarmerfailed', 'Failed');
        }

        
    }
}
