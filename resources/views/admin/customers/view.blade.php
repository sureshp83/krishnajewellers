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

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="header">
                            <h2> Customer Order History</h2>
                        </div>

                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-md-12 col-lg-12">
                                    <div class="panel-group" id="accordion_10" role="tablist" aria-multiselectable="true">

                                        @foreach($customerDetail->orders as $key => $customerOrder)
                                        <div class="panel panel-col-green">
                                            <div class="panel-heading" role="tab" id="headingOne_{{$key}}">
                                                <h4 class="panel-title"><a role="button" data-toggle="collapse" data-parent="#accordion_{{$key}}" href="#collapseOne_{{$key}}" aria-expanded="true" aria-controls="collapseOne_{{$key}}"> {{$customerOrder->unique_order_id}} </a> </h4>
                                            </div>
                                            <div id="collapseOne_{{$key}}" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne_{{$key}}">
                                                <div class="panel-body">
                                                    <table class="table">
                                                        <thead>
                                                            <th>Date</th>
                                                            <th>Credit Amount</th>
                                                            <th>Debit Amount</th>
                                                            <th>View Order Detail</th>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>{{$customerOrder->created_at}}</td>
                                                                <td>{{$customerOrder->total_cost}}</td>
                                                                <td>{{$customerOrder->total_cost}}</td>
                                                                <td><a href="{{route('orders.show',[$customerOrder->id])}}" class="btn btn-raised waves-effect waves-float waves-light-blue m-l-5" title="View order detail"><i class="zmdi zmdi-eye"></i></a></td>
                                                                    
                                                            </tr>    
                                                        </tbody>        
                                                    </table>    
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    
                                        
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>        
            </div>

            @include('admin.common.footer_detail')           
        </div>   
    </section>
@endsection