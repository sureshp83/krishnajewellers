<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\CustomerLoan;
use App\Model\Order;
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
        $totalProduct = Product::count();
        $totalOrder = Order::count();
        $totalLoan = CustomerLoan::count();
        
        
        return view('admin.dashboard',[
            'totalCustomer' => $totalCustomer,
            'totalProduct' => $totalProduct,
            'totalOrder' => $totalOrder,
            'totalLoan' => $totalLoan
        ]);
    }
}
