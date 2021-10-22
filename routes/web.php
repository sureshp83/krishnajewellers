<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('admin')->group(function(){

    Route::get('/', 'Auth\AdminLoginController@showLoginForm')->name('adminLogin');

    Route::get('login', 'Auth\AdminLoginController@showLoginForm')->name('adminLogin');

    Route::post('login', 'Auth\AdminLoginController@login');

    //Forgot password
    Route::get('forgot/password', 'Auth\AdminForgotPasswordController@index')->name('adminForgotPassword');
    Route::post('forgot/password', 'Auth\AdminForgotPasswordController@checkUserIsAdmin')->name('adminForgotPassword');

    // Reset password
    Route::post('password/reset', 'Auth\AdminResetPasswordController@reset')->name('admin.password.reset_process');
    Route::get('password/reset/{token}/{email}', 'Auth\AdminResetPasswordController@showResetForm')->name('password.reset');
    
    Route::middleware(['auth:admin'])->group(function(){
        //Dashboard
        Route::get('dashboard', 'Admin\AdminDashboardController@showDashboard')->name('adminDashboard');
        Route::get('logout', 'Auth\AdminLoginController@logout')->name('adminLogout');

        // Edit profile
        
        Route::get('profile', 'Admin\AdminProfileController@showProfile')->name('editAdminProfile');
        Route::post('profile', 'Admin\AdminProfileController@updateProfile')->name('updateAdminProfile');


        // Change Password
        Route::post('change/password', 'Admin\AdminProfileController@updateAdminChangePassword')->name('updateAdminChangePassword');

        Route::post('upload-admin-profile', 'Admin\AdminProfileController@uploadAdminProfile')->name('upload-admin-profile');
        
        // Customers
        Route::resource('customers', 'Admin\AdminCustomersController');
        Route::post('customers/search', 'Admin\AdminCustomersController@search')->name('customers.search');
        Route::post('customers/status/{customer}', 'Admin\AdminCustomersController@changeStatus')->name('customers.status');

        // Products
        Route::resource('products', 'Admin\AdminProductController');
        Route::post('products/search', 'Admin\AdminProductController@search')->name('products.search');
        Route::post('products/status/{product}', 'Admin\AdminProductController@changeStatus')->name('products.status');


        // orders
        Route::resource('categories', 'Admin\AdminCategoryController');
        Route::post('categories/search', 'Admin\AdminCategoryController@search')->name('categories.search');
        

        // orders
        Route::resource('orders', 'Admin\AdminOrdersController');
        Route::post('orders/search', 'Admin\AdminOrdersController@search')->name('orders.search');
        Route::post('add-more-payment', 'Admin\AdminOrdersController@addMoreOrderPayment')->name('orders.add-more-payment');
        Route::post('orders/status', 'Admin\AdminOrdersController@changeOrderStatus')->name('orders.status');

        // reports
        Route::resource('loans', 'Admin\AdminCategoryController');
        Route::post('loans/search', 'Admin\AdminCategoryController@search')->name('loans.search');
        Route::post('loans/status/{category}', 'Admin\AdminCategoryController@changeStatus')->name('loans.status');

       

    });    

});

Route::get('/home', 'HomeController@index')->name('home');
