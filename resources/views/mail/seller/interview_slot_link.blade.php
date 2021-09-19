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
                                <td height="25" style="font-size: 1px;">&nbsp;</td>
                            </tr>
                            <tr>
                                <td class="agile-main scale-center-both" style="font-weight: 400; color: #000; font-size: 15px; text-align:left; height:34px !important;">
                                Hello {{$jobDetail->candidate_name}},<br>
                                {{-- <ui>Here is the job description for <b>{{$jobDetail->job_title}}</b></ui><br> --}}
                            </td>
                            <tr>
                                <td height="25" style="font-size: 1px;">&nbsp;</td>
                            </tr>
                            </tr>
                            <tr>
                                <td class="agile-main scale-center-both" style="font-weight: 400; color: #000; font-size: 15px; text-align:left; height:34px !important;">
                                Job Title :- {{$jobDetail->job_title}}<br>
                                Experience :- {{$jobDetail->experience}}<br>
                                Location :- {{$jobDetail->location}}<br>
                                </td>
                            </tr>
                            <tr>
                                <td height="25" style="font-size: 1px;">&nbsp;</td>
                            </tr>
                            <tr>
                                <td class="agile-main scale-center-both" style="font-weight: 400; color: #000; font-size: 15px; text-align:left; height:34px !important;">
                                    Interview slots ready for this job. kindly choose one of them
                                    <b>Interview Slot Request Link :-</b>
                                    <a href="{{$url}}">Click Here</a>
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
                                <td class="w3l-p2 scale-center-both" style="font-weight: 400; color: #000; font-size: 14px; line-height: 20px; text-align:left;">Thanks for using <span style="color:#007AFF">{{env('APP_NAME')}}.</span>
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