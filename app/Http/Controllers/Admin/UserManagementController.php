<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Barangay;
use Session;
use Auth;

class UserManagementController extends Controller
{
    public function userManagement()
    {
        $user = User::with('role','municipality')->get();
        $barangay = Barangay::where("municipality_id", Auth::user()->muni_address)->get(); 
        return view('admin.userManagement', array('users' => $user, "barangays" => $barangay));
    }

    public function createUser(Request $request)
    {
        $request->validate([
            'role_id'  => 'required',
            'name'  => 'required',
            'muni_address' => 'required',
            'email' => 'required|email|unique:approvals|unique:users',
            'password' => 'required|confirmed|min:8|max:12',
        ]);

        $user =  new User();
        $user->role_id = $request->role_id;
        $user->name = $request->name;
        $user->muni_address = $request->muni_address;
        $user->email = $request->email;
        $user->acc_status = 1;
        $user->password = Hash::make($request->password);
        $res = $user->save();

        if($res){
            return back()->with('accountCreated', 'Created Sucessfully');
        } else{
            return back()->with('accountCreateFailed', 'Failed');
        }
    }

    public function userUpdate(Request $request, $id)
    {
        $request->validate([
            'name'  => 'required',
            'email' => 'required|unique:users,email,'. $id,
        ]);

        
        $res = DB::table('users')->where('id', $id)->update(['name' => $request->name, 'email' => $request->email]);
        
        if($res){
            return back()->with('accountUpdated', 'Update Sucessfully');
        } else{
            return back()->with('accountUpdatedfailed', 'Update Failed');
        }
    }

    public function userchangePassword(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|confirmed|min:5|max:12',
        ]);
        
        $res = DB::table('users')->where('id', $id)->update(['password' => Hash::make($request->password)]);
        
        if($res){
            return back()->with('passwordUpdated', 'Update Sucessfully');
        } 
    }

    public function changeaccStatus(Request $request)
    {
        $user = User::find($request->id);
        $user->acc_status = $request->status;
        $user->save();

        return response()->json(['success'=>'Status change successfully.']);
    } 

}
