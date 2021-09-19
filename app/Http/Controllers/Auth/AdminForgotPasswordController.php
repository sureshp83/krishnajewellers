<?php

namespace App\Http\Controllers\Auth;

use App\Model\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class AdminForgotPasswordController extends ForgotPasswordController
{
    /*
    |--------------------------------------------------------------------------
    | Stockist Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    /**
     * Display login form.
     *
     * @return void
     */
    public function index()
    {
        return view('admin.auth.forgot_password');
    }

    /**
     * Check email address is admin user
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function checkUserIsAdmin(Request $request)
    {
        $this->validateEmail($request);

        $user = Admin::where(['email' => $request->email])->first();
        
        if (!empty($user)) 
        {
            session()->put('passwordBroker', 'admin');
            
            return $this->sendResetLinkEmail($request);
        }
        
        return redirect()->back()->with('error', trans('auth.wrongemail'));
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return PasswordBroker
     */
    public function broker()
    {
        return Password::broker('admins');
    }

    /**
     * Get the response for a successful password reset link.
     *
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetLinkResponse(Request $request, $response)
    {
        
        return back()->with('success', trans($response));
    }

    /**
     * Get the response for a failed password reset link.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        return back()
            ->withInput($request->only('email'))
            ->with('error', trans($response));
    }
}
