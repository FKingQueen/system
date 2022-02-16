<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
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

        $res = DB::table('users')->where('id', $id)->update(['name' => $request->name, 'password' => Hash::make($request->password)]);
        
        if($res){
            return redirect()->route('userManagement')->with('success', 'Update Sucessfully');
        } 
    }

    public function changeProfile(Request $request, $id)
    {
        $request->validate([
            'prof_image' => 'required',
        ]);

        $user = User::find($id);

        if($request->prof_image != ''){        
             $path = public_path().'/uploads/user/';
   
             //code for remove old file
             if($user->email != ''  && $user->email != null){
                  $file_old = $path.$user->email;
                  unlink($file_old);
             }
   
             //upload new file
             $file = $request->file;
             $filename = $file->getClientOriginalName();
             $file->move($path, $filename);
   
             //for update in table
             $employee->update(['prof_image' => $filename]);
        }
    
    }
}
