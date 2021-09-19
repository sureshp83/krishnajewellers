<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Model\Product;
use App\Model\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Admin Dashboard Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles  Admin users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */


    /**
     * Admin dashboard
     *
     * @return void
     */
    public function showDashboard()
    {
        $admin = \Auth::guard('admin')->user();
        
        
        $totalCustomer = User::count();
        
        
        return view('admin.dashboard',[
            'totalCustomer' => $totalCustomer
        ]);
    }
}
