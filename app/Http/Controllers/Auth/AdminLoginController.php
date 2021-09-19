<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends LoginController
{
    /*
    |--------------------------------------------------------------------------
    | Admin Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating admin users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    protected $redirectTo = "/admin/dashboard";

    protected $guard = 'admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Show login page
     * @param Request void
     * 
     * @return Response view
     * 
     */
    public function showLoginForm()
    {
        if(Auth::guard('admin')->check())
        {
            return redirect(route('adminDashboard'));    
        }
        return view('admin.auth.login');
    }

    
    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {   
        return [
            'email' => $request->email,
            'password' => $request->password
        ];
        
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {   
        
        if(Auth::guard('admin')->check())
        {
            return redirect('admin/dashboard');   
        }
        else
        {   
            $this->guard('admin')->logout();
            return redirect('admin')->with('error', trans('auth.failed'));
        }
        
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {  
        
        $request->session()->regenerate();
        $this->clearLoginAttempts($request);
       // $this->incrementLoginAttempts($request);
     
        return $this->authenticated($request, $this->guard()->user())
            ?: redirect()->intended($this->redirectPath());
    }


    /**
     * Logout
     * @param Request $request
     * 
     * @return Response Json
     * 
     */
    public function logout(Request $request)
    {

        $this->guard('admin')->logout();
        
        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect(route('adminLogin'));
    }

}
