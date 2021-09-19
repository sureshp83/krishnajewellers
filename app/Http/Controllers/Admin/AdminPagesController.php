<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\ModelStaticPage;
use Illuminate\Http\Request;

class AdminPagesController extends Controller
{
    /**
     * Display a about us content.
     *
     * @return \Illuminate\Http\Response
     */
    public function aboutus()
    {
        $aboutUs = StaticPage::where('type_id', 1)->select('title', 'content')->first();

        return view('admin.pages.aboutus', compact('aboutUs'));
    }

    /**
     * Update about us content
     * @param Request $request
     * 
     * @return Response Json
     * 
     */
    public function updateAboutus(Request $request)
    {
        $this->validate($request, [
            'content' => 'required'
        ]);

        $staticPage = new StaticPage();
        $staticPage->type_id = 1;
        $staticPage->title = 'about us';
        $staticPage->content = $request->content;

        if($staticPage->save())
        {
            return redirect()->back()->with('success', trans('messages.static_pages.aboutus.success'));
        }

        return redirect()->back()->with('error', trans('messages.static_pages.aboutus.error'));
    }


    /**
     * Display a privacy policy content.
     *
     * @return \Illuminate\Http\Response
     */
    public function privacyPolicy()
    {
        $privacyPolicy = StaticPage::where('type_id', 2)->select('title', 'content')->first();

        return view('admin.pages.privacyPolicy', compact('privacyPolicy'));
    }


    /**
     * Update privacy policy content
     * @param Request $request
     * 
     * @return Response Json
     * 
     */
    public function updatePrivacyPolicy(Request $request)
    {
        
        $this->validate($request, [
            'content' => 'required'
        ]);
        
        $staticPage = new StaticPage();
        $staticPage->type_id = 2;
        $staticPage->title = 'privacy policy';
        $staticPage->content = $request->content;

        if($staticPage->save())
        {
            return redirect()->back()->with('success', trans('messages.static_pages.privacy_policy.success'));
        }

        return redirect()->back()->with('error', trans('messages.static_pages.privacy_policy.error'));
    }



    /**
     * Display a terms and conditions content.
     *
     * @return \Illuminate\Http\Response
     */
    public function termsCondition()
    {
        $termsCondition = StaticPage::where('type_id', 3)->select('title', 'content')->first();

        return view('admin.pages.termsCondition', compact('termsCondition'));
    }


    /**
     * Update terms and conditions content
     * @param Request $request
     * 
     * @return Response Json
     * 
     */
    public function updateTermsCondition(Request $request)
    {
        
        $this->validate($request, [
            'content' => 'required'
        ]);
        
        $staticPage = new StaticPage();
        $staticPage->type_id = 3;
        $staticPage->title = 'terms and condition';
        $staticPage->content = $request->content;

        if($staticPage->save())
        {
            return redirect()->back()->with('success', trans('messages.static_pages.terms_condition.success'));
        }

        return redirect()->back()->with('error', trans('messages.static_pages.terms_condition.error'));
    }


    /**
     * Display a return refund policy content.
     *
     * @return \Illuminate\Http\Response
     */
    public function returnRefundPolicy()
    {
        $returnRefund = StaticPage::where('type_id', 4)->select('title', 'content')->first();

        return view('admin.pages.returnRefund', compact('returnRefund'));
    }


    /**
     * Update terms and conditions content
     * @param Request $request
     * 
     * @return Response Json
     * 
     */
    public function updateReturnRefundPolicy(Request $request)
    {
        
        $this->validate($request, [
            'content' => 'required'
        ]);
        
        $staticPage = new StaticPage();
        $staticPage->type_id = 4;
        $staticPage->title = 'return and refund policy';
        $staticPage->content = $request->content;

        if($staticPage->save())
        {
            return redirect()->back()->with('success', trans('messages.static_pages.return_refund.success'));
        }

        return redirect()->back()->with('error', trans('messages.static_pages.return_refund.error'));
    }


}
