<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Approval;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Roles;
use Session;
use Auth;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function approved(Request $request, $id)
    {
        $request->validate([
            'role_id'  => 'required',
        ]);

        $data = DB::table('approvals')->find($id);

        $user =  new User();
        $user->role_id = $request->role_id;
        $user->name = $data->name;
        $user->muni_address = $data->muni_address;
        $user->email = $data->email;
        $user->password = $data->password;
        $user->save();

        $approval = Approval::find($id);
        $dest = 'uploads/approval/'.$approval->id_confirm;
        if(File::exists($dest))
        {
            File::delete($dest);
        }

        $del = DB::table('approvals')->where('id', $id);
        $del->delete();

        return back();
    }
}
