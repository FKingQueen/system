<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
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
        $user = User::find($id);

        if($request->hasfile('prof_image'))
        {
            $dest = 'uploads/user/'.$user->prof_image;
            if(File::exists($dest))
            {
                File::delete($dest);
            }
            $file = $request->file('prof_image');
            $extension = $file->getClientOriginalExtension();
            $filename = $user->email.'.'.$extension;
            $file->move('uploads/user/', $filename);
            $user->prof_image = $filename;
        }
        $res = $user->update();

        if($res){
            return back()->with('success', 'Update Sucessfully');
        } else{
            return back()->with('fail', 'Nothing Change');
        }
    
    }
}
