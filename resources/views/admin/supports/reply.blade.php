@extends('admin.layout.index')
@section('title') View Support Query @endsection

@section('content')
<section class="content home">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="header">
                        <h2> Support Query Details </h2>
                    </div>
                    @include('admin.common.flash')

                    <div class="col-md-12 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('adminDashboard') }}"><i class="zmdi zmdi-home"></i> Home</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{ route('supports.index') }}"> Supports</a>
                                </li>
                                <li class="breadcrumb-item active">Support Query Details</li>
                            </ol>

                        </div>
                    </div>

                    <div class="body">
                        <div class="col-md-12">
                            <div class="row clearfix">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="custom-label">Sender Name : </label>
                                        <label class="custom-label">{{$support->sender_name}}</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="custom-label">Date : </label>
                                        <label class="custom-label">{{$support->createdDate}}</label>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="row clearfix">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="custom-label">Query : </label>
                                        <label class="custom-label">{{$support->support_message}}</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- <form method="post" class="replyForm" action="{{route('supports.submitReply')}}">
                            {{csrf_field()}}
                            <div class="col-md-12">
                                <div class="row clearfix">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="custom-label">Reply : </label>
                                            @if(!empty($support->reply))
                                            <label class="custom-label">{{$support->reply}}</label>
                                            @else
                                            <input type="hidden" name="support_id" id="support_id" value="{{$support->id ?? ''}}">
                                            <textarea name="reply" id="reply" class="form-control" placeholder="Please enter your reply"></textarea>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if(empty($support->reply))
                            <div class="col-md-12">
                                <div class="row clearfix">
                                    <input type="submit" class="btn btn-success" name="submitReply" id="submitReply" value="Submit">
                                </div>
                            </div>
                            @endif
                        </form> --}}

                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('js')
<script>
    $(".replyForm").validate({
        rules: {
                reply: {
                    required: true
                }
        },
        messages:{
            reply : {
                required : 'Please enter your reply'
            }
        }    
    });    
</script>   
@endsection