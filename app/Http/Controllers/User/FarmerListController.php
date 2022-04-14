<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Farming_data;
use App\Models\Farmer;
use App\Models\User;
use App\Models\Barangay;
use App\Models\Activity_files;
use App\Models\Municipality;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\FarmersImport;
use Auth;


class FarmerListController extends Controller
{

    public function farmerList()
    {
        $municipality = DB::table("municipalities")->pluck("name","id");
        $farming_data = Farming_data::all(); 
        $farmer = Farmer::with('barangays')->get()->where("user_id", Auth::user()->id);
        $barangay = Barangay::where("municipality_id", Auth::user()->muni_address)->get();

        foreach($farmer as $key => $farmers)
        {
            $chk = Farming_data::where("farmer_id", $farmers->id)->where("status", 1)->get();

            if($chk->isEmpty())
            {
                DB::table('farmers')
                    ->where('id', $farmers->id)
                    ->update([
                    'status' => 0, 
                ]);
            } else if($chk->isNotEmpty())
            {
                DB::table('farmers')
                    ->where('id', $farmers->id)
                    ->update([
                    'status' => 1, 
                ]);
            }

        }

        $farmer = Farmer::with('barangays', 'municipality')->orderBy('status', 'DESC')->get()->where("user_id", Auth::user()->id);

        foreach($farmer as $key=> $f)
        {
            $far[$key][0] = Farming_data::where("farmer_id", $f->id)->where("status", 1)->count();
        }

        if($farmer->isEmpty())
        {
            $far[0] = null;
        } 

        
        return view('user/farmerList', array('far' => $far, 'municipalities' => $municipality, 'farmers' => $farmer, 'farming_datas' => $farming_data, 'barangays' => $barangay));
    }

    public function farmerListAjax($id)
    {
        $barangays = DB::table("barangays")
                    ->where("municipality_id",Auth::user()->muni_address)
                    ->pluck("name","id");
        return json_encode($barangays);
    }

    public function addFarmer(Request $request)
    {

        $request->validate([
            'name'  => 'required|unique:farmers',
            'barangay'  => 'required',
        ]);

        $muni = DB::table("municipalities")->where("id", Auth::user()->muni_address)->value('name');

        $farmer =  new Farmer();
        $farmer->name = $request->name;
        $farmer->municipality_id = Auth::user()->muni_address;
        $farmer->barangay_id = $request->barangay;
        $farmer->status = '2';
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
       
        $res = DB::table('farmers')
            ->where('id', $id)
            ->update([
            'name' => $request->name, 
            'barangay_id'  => $request->barangay
            ]);

            DB::table('farming_datas')
            ->where('farmer_id', $id)
            ->update([
            'barangay_id'  => $request->barangay
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

    public function importfarmer(Request $request)
    {
        $request->validate([
            'importfarmer' => 'required|mimes:xlsx, csv, xls'
        ]);

        $user_id = Auth::user()->id;

        $path = $request->file('importfarmer')->getRealPath();
        $res = Excel::import(new FarmersImport($user_id), $path);

        if($res){
            return redirect()->route('farmerList')->with('uploadedfarming', 'Success');
        } else{
            return redirect()->route('farmerProfile')->with('uploadfarmingfailed', 'Failed');
        }
    }
}

