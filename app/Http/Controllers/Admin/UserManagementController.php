<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

use App\Models\User;
use Session;

class UserManagementController extends Controller
{
    public function userManagement()
    {
        $user = User::with('role')->get();
        return view('admin.userManagement', array('users' => $user));
    }

    public function userUpdate(Request $request, $id)
    {
        $request->validate([
            'name'  => 'required',
            'muni_address' => 'required',
            'email' => 'required',
        ]);

        
        $res = DB::table('users')->where('id', $id)->update(['name' => $request->name, 'email' => $request->email, 'muni_address' => $request->muni_address,]);
        
        if($res){
            return back()->with('success', 'Update Sucessfully');
        } else{
            return back()->with('fail', 'Nothing Change');
        }
    }

    public function userchangePassword(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|confirmed|min:5|max:12',
        ]);
        
        $res = DB::table('users')->where('id', $id)->update(['password' => Hash::make($request->password)]);
        
        if($res){
            return back()->with('success', 'Update Sucessfully');
        } else{
            return back()->with('fail', 'Nothing Change');
        }
    }
}
