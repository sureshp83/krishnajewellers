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
                                Hello {{ $interviewDetail->first_name}},<br>
                                
                            </td>
                            
                            <tr>
                                <td class="agile-main scale-center-both" style="font-weight: 400; color: #000; font-size: 15px; text-align:left; height:34px !important;">
                                Your interview confirmed details. <br></td>
                            </tr>
                            <tr>
                                <td class="agile-main scale-center-both" style="font-weight: 400; color: #000; font-size: 15px; text-align:left; height:34px !important;">
                                    <b>Interview Round</b> &nbsp;:&nbsp; {{ $interviewDetail->round_no }} <br>
                                    <b>Interview Date</b> &nbsp;:&nbsp;  {{ $interviewDetail->interview_date }} <br>
                                    <b>Interview Time</b> &nbsp;:&nbsp;  {{ $interviewDetail->start_time }} - {{ $interviewDetail->end_time }}<br>
                                    <b>Interview Address</b> &nbsp;:&nbsp;{{ $interviewDetail->address }}
                                </td>
                            </tr>
                            
                            
                            <tr>
                                <td height="15" style="font-size: 1px;">&nbsp;</td>
                            </tr>
                            <tr>
                                <td class="w3l-p2 scale-center-both" style="font-weight: 400; color: #000; font-size: 14px; line-height: 20px; text-align:left;">Thanks for using <span style="color:#007AFF">{{config('app.name')}}.</span>
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