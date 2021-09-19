@extends('mail.layout.index')
@section('header')
<tr>
    <td bgcolor="#FFFFFF" style="border-top-left-radius: 4px; border-top-right-radius: 4px;">
        <table width="540" border="0" cellspacing="0" cellpadding="0" align="center" class="scale">
            <tr>
                <td class="w3l-4h user_name" height="84px" style="color: #000;"></td>
            </tr>
        </table>
    </td>
</tr>
@endsection

@section('content')
    <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
        <td bgcolor="#007AFF">
            <table width="620" border="0" cellspacing="0" cellpadding="0" align="center" class="scale section">
                <tr>
                    <td bgcolor="#FFFFFF">
                        <table width="540" border="0" cellspacing="0" cellpadding="0" align="center" class="agile1 scale">
                            <tr>
                                <td class="agile-main scale-center-both" style="font-weight: 400; color: #000; font-size: 15px; text-align:left; height:34px !important;">
                                Hello {{ $candidateDetails->first_name}},<br>
                                
                            </td>
                            
                            <tr>
                                <td class="agile-main scale-center-both" style="font-weight: 400; color: #000; font-size: 15px; text-align:left; height:34px !important;">
                                You have been invited to {{ config('app.name') }}, please find your account login credentials details below <span style="color:#8a0000">{{env('APP_NAME')}}.</span></td>
                            </tr>
                            <tr>
                                <td class="agile-main scale-center-both" style="font-weight: 400; color: #000; font-size: 15px; text-align:left; height:34px !important;">
                                    <b>Phone number</b> &nbsp;:&nbsp; {{ $candidateDetails->country_code.$candidateDetails->mobile_number }} <br>
                                    <b>Password</b> &nbsp;:&nbsp; {{ $candidateDetails->show_password }}
                                </td>
                            </tr>
                            
                            <tr>
                                <td height="25" style="font-size: 1px;">&nbsp;</td>
                            </tr>
                            <tr>
                                <td class="w3l-p2 scale-center-both" style="font-weight: 400; color: #000; font-size: 14px; line-height: 20px; text-align:left;">
                                </td>
                            </tr>

                            <tr>
                                <td height="15" style="font-size: 1px;">&nbsp;</td>
                            </tr>
                            <tr>
                                <td class="w3l-p2 scale-center-both" style="font-weight: 400; color: #000; font-size: 14px; line-height: 20px; text-align:left;">Thanks for using <span style="color:#007AFF">{{config('app.name')}}.</span>
                                </td>
                            </tr>
                            <tr ><td><h3>Download our app</h3></td></tr>
                            <tr style="margin-top: 50px;">
                              <td>
                                <div class="app-img" style="text-align: left;">
                                  <a href="javascript:void(0);"><img src="{{url('recruiter-assets/images/ios.png')}}"></a>
                                </div>
                              </td>
                              <td>
                                <div class="app-img" style="text-align: left;">
                                  <a href="javascript:void(0);"><img src="{{url('recruiter-assets/images/android.png')}}"></a>
                                </div>
                              </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
@endsection