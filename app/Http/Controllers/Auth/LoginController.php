<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;


    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return \Auth::guard($this->guard);
    }
    
    /**
       * Get the needed authorization credentials from the request.
       *
       * @param  \Illuminate\Http\Request  $request
       * @return array
       */
      protected function credentials(Request $request)
      {
        if(!$request->get('email'))
        {
          return ['country_code' => $request->get('country_code'),'mobile_number'=>$request->get('mobile_number'),'password'=>$request->get('password'),'role_id' => $request->get('role_id')];
        }
        elseif (filter_var($request->get('email'), FILTER_VALIDATE_EMAIL)) {
        
          return ['email' => $request->get('email'), 'password'=>$request->get('password')];
        }
        
        return ['country_code' => $request->get('country_code'),'mobile_number'=>$request->get('mobile_number'),'password'=>$request->get('password'),'role_id' => $request->get('role_id')];
      }


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
