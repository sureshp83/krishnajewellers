<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminProfileController extends Controller
{
    //

    /**
     * View  admin profile
     * 
     * @return view
     */
    public function showProfile()
    {
        $admin = Auth::guard('admin')->user();

        return view(
            'admin.profile',
            [
                'admin' => $admin
                
            ]
        );
    }


    /**
     * Update admin password
     * 
     * @param Request $request
     * 
     * @return Response Json
     * 
     */
    public function updateAdminChangePassword(Request $request)
    {
        $this->validate($request, [
            'current_password' => 'required',
            'new_password' => 'required',
            'confirm_password' => 'required|same:new_password'
        ]);

        $admin = Auth::guard('admin')->user();

        if(\Hash::check($request->current_password, $admin->password))
        {
            $admin->password = bcrypt($request->new_password);
            
            if($admin->save())
            {
                return redirect()->back()->with('success', trans('messages.profile.admin.change_password_success'));
            }

            return redirect()->back()->with('error', trans('messages.profile.admin.change_password_error'));
        }

        return redirect()->back()->with('error', trans('messages.profile.admin.password_not_match'));
    }


    /**
     * Update profile
     * 
     * @param Request $request
     * 
     * @return Response view
     * 
     */
    public function updateProfile(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'phone_number' => 'required',
            'profile_image' => 'nullable'
        ]);
        //dd($request->all());    
        $admin = Auth::guard('admin')->user();
        $admin->fill($request->all());
        
        if(!empty($request->profile_image))
        {
            
            $basePath = config('constant.ADMIN_AVATAR');'admin-assets/images/profile_image/';
            $image = $request->file('profile_image');
            $fileName = time().'_'.strtolower(\Str::random(6)).'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path($basePath);
                
            if($image->move($destinationPath, $fileName))
            {
                chmod($destinationPath.'/'.$fileName,0777);
                $admin->profile_image = $fileName;
            }
        }
        

        if($admin->save())
        {
            return redirect()->back()->with('success', trans('messages.profile.admin.profile_update_success'));
        }

        return redirect()->back()->with('error', trans('messages.profile.admin.profile_update_error'));
    }
}
