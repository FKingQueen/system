<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;


    public function logout(Request $request) {
        Auth::logout();
        return redirect('/login');
      }

      
      protected function authenticated(Request $request, $user)
    {
        if(Auth::user()->role_id == 1)
        {
            return redirect()->route('userManagement');
        } 
    
        if(Auth::user()->role_id == 2)
        {
            return redirect()->route('farmerList');
        }
        
        return redirect('/home');
    }
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }
    
}
