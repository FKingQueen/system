<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Approval;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Role;
use Session;
use Auth;


class RegistrationApprovalController extends Controller
{
    public function registrationApproval()
    {
        $approval = Approval::all();
        $municipality = DB::table("municipalities")->pluck("name","id");
        return view('admin.registrationApproval', array('approvals' => $approval, "municipalities" => $municipality));
    }

    public function registration(Request $request)
    {

        $request->validate([
            'name'  => 'required',
            'muni_address' => 'required',
            'email' => 'required|email|unique:approvals|unique:users',
            'password' => 'required|confirmed|min:5|max:12',
        ]);

        $approval =  new Approval();
        $approval->name = $request->name;
        $approval->muni_address = $request->muni_address;
        $approval->email = $request->email;
        $approval->password = Hash::make($request->password);
        if($request->hasfile('id_confirm'))
        {
            $file = $request->file('id_confirm');
            $extension = $file->getClientOriginalExtension();
            $filename = $request->email.'.'.$extension;
            $file->move('uploads/approval/', $filename);
            $approval->id_confirm = $filename;
        }
        $res = $approval->save();

        if($res){
            return back();
        } else{
            return back();
        }
    }
}
