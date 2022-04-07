<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Approval;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Role;
use App\Models\Barangay;
use Session;
use Auth;


class RegistrationApprovalController extends Controller
{
    public function registrationApproval()
    {
        $approval = Approval::all();
        $barangay = Barangay::where("municipality_id", Auth::user()->muni_address)->get(); 
        return view('admin.registrationApproval', array('approvals' => $approval, "barangays" => $barangay));
    }

    public function registration(Request $request)
    {

        $request->validate([
            'name'  => 'required',
            'muni_address' => 'required',
            'email' => 'required|email|unique:approvals|unique:users',
            'password' => 'required|confirmed|min:8|max:12',
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
            return back()->with('registrationsuccess', 'Success');
        } else{
            return back()->with('registrationfailed', 'Failed');
        }
    }
}
