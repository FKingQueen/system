<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Models\User;
use App\Models\Barangay;
use Illuminate\Validation\Rule;
use Hash;
use Auth;

class AccountSettingController extends Controller
{
    public function accountSetting()
    {
        $barangay = Barangay::where("municipality_id", Auth::user()->muni_address)->get();
        return view('accountSetting', array("barangays" => $barangay));
    }

    public function updateAccount(Request $request, $id)
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

    public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|confirmed|min:8|max:12',
        ]);

        $res = DB::table('users')->where('id', $id)->update(['password' => Hash::make($request->password)]);
        
        if($res){
            return back()->with('passwordUpdated', 'Update Sucessfully');
        } else{
            return back()->with('accountUpdatedfailed', 'Update Failed');
        }
    }

    public function changeProfile(Request $request, $id)
    {
        $user = User::find($id);

        $request->validate([
            'prof_image' => 'required|image|mimes:jpeg,jpg,png',
        ]);

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
