<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Hash;

class AccountSettingController extends Controller
{
    public function accountSetting()
    {
        return view('accountSetting');
    }

    public function updateAccount(Request $request, $id)
    {

        $request->validate([
            'password' => 'required|confirmed|min:5|max:12',
        ]);

        $data = DB::table('users')->where('id', $id)->update(['name' => $request->name, 'password' => Hash::make($request->password)]);
        
        if($data){
            return redirect()->route('userManagement')->with('success', 'Update Sucessfully');
        } 
    }
}
