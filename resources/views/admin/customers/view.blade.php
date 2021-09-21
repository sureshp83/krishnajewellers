@extends('admin.layout.index')
@section('title') Customers @endsection

@section('content')
<section class="content">
       <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>Customer Detail
                    </h2>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-12">
                    <ul class="breadcrumb float-md-right">
                        <li class="breadcrumb-item"><a href="{{route('adminDashboard')}}"><i class="zmdi zmdi-home"></i> Home</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12">
                    <!-- View -->
                        <div class="row clearfix">
                            <div class="col-lg-6 col-md-12">
                                <div class="card member-card">
                                    <div class="header l-app">
                                    </div>
                                    <div class="member-img m-t-5">
                                        <img src="{{url($customerDetail->profile_image)}}" class="rounded-circle" alt="profile-image" width="100" height="150px">
                                    </div>
                                    <div class="body">
                                        <div class="col-12">
                                            <ul class="list-inline">
                                                <li><h4 class="m-t-5">{{$customerDetail->name}} </h4></li>
                                                
                                            </ul>
                                        </div>
                                        <hr>
                                        <ul class="list-unstyled text-left">
                                            <li class="m-l-50 m-b-10">
                                                <i class="zmdi zmdi-email col-app m-r-10"></i>
                                                <spna class="font-15">{{$customerDetail->email}}</spna>
                                            </li>
                                            <li class="m-l-50 m-b-10">
                                                <i class="zmdi zmdi-home col-app m-r-10"></i>
                                                <spna class="font-15">{{$customerDetail->village_name}}</spna>
                                            </li>
                                            
                                            <li class="m-l-50 m-b-10">
                                                <i class="zmdi zmdi-smartphone-iphone col-app m-r-10"></i>
                                                <spna class="font-15">{{$customerDetail->phone_number}}</spna>,&nbsp;&nbsp;
                                                <spna class="font-15">{{$customerDetail->alternate_phone_number}}</spna>
                                            </li>
                                            <li class="m-l-50 m-b-10">
                                            <spna class="font-15">Join Date : </spna>
                                                <spna class="font-15">{{$customerDetail->join_date}}</spna>
                                            </li>
                                        </ul>
                                    </div>


                                </div>
                                
                            </div>
                        </div>
                    <!-- End View -->
                </div>
            </div>
            @include('admin.common.footer_detail')           
        </div>   
    </section>
@endsection