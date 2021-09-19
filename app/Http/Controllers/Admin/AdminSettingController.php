<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\ModelCity;
use App\ModelCountry;
use App\ModelSetting;
use App\ModelState;
use Illuminate\Http\Request;

class AdminSettingController extends Controller
{
    
    /**
     * Setting index
     * 
     */
    public function index()
    {
        $settings = Setting::selectRaw('id,type,module_id,value')->get();
        $settings = $settings->groupBy('type');
        
        $countryIds = Country::where('is_active',1)->select('id')->pluck('id')->toArray();
        
        $stateIds = State::whereIn('country_id', $countryIds)->select('id')->pluck('id')->toArray();
        
        $cities = City::whereIn('state_id', $stateIds)->select('id','name')->get();
        
        return view('admin.settings.index', compact('settings', 'cities'));
    }


    /**
     * Update setting
     * @param Request $request
     * 
     * @return Response Json
     * 
     */
    public function store(Request $request)
    {
        $vatSetting = Setting::where('type', 'vat')->delete();

        $vatSetting = new Setting();
        $vatSetting->type = 'vat';
        $vatSetting->value = $request->vat;
        $vatSetting->save();
    
        Setting::where('type', 'delivery_charge')->delete();

        $countryIds = Country::where('is_active',1)->select('id')->pluck('id')->toArray();
        
        $stateIds = State::whereIn('country_id', $countryIds)->select('id')->pluck('id')->toArray();
        
        $cities = City::whereIn('state_id', $stateIds)->select('id','name')->get();

        foreach($cities as $key => $delchrg)
        {
            $delchrgSetting = new Setting();
            $delchrgSetting->type = 'delivery_charge';
            $delchrgSetting->module_id = $delchrg->id;
            $delchrgSetting->value = !empty($request->input('delivery_charge-'.$delchrg->id)) ? $request->input('delivery_charge-'.$delchrg->id) : 0;
            $delchrgSetting->save();
        }

        return redirect(route('settings.index'))->with('success', trans('messages.settings.success'));

    }
}
