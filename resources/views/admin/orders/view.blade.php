@extends('admin.layout.index')
@section('title') Orders @endsection
@section('css')
<link rel="stylesheet" href="{{ url('admin-assets/plugins/select2/dist/css/select2.css') }}" />
@endsection
@section('content')
<section class="content">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2> Order Detail
                </h2>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12">
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><a href="{{ route('adminDashboard') }}"><i class="zmdi zmdi-home"></i> Dashboard</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-12">
                <div class="card">
                
                    <div class="body">
                    <a href="{{route('orders.index')}}" class="btn btn-primary m-t-20 float-right">Back</a>
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group form-float">
                                    <label class="custom-label">Order ID : {{$orderDetail->unique_order_id}}</label>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6">
                                <div class="form-group form-float">
                                    <label class="custom-label">Order Date Time : {{$orderDetail->order_datetime}}</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-lg-6 col-md-6">
                                <div class="form-group form-float">
                                    <label class="custom-label">Customer Name : {{$orderDetail->customer_name}}</label><br>
                                    <a href="{{route('customers.show',['customer' => $orderDetail->customer_id])}}" class="badge bg-pink">View Customer Info</a>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-3">
                                <div class="form-group form-float">
                                    <label class="custom-label">Category : {{$orderDetail->category_name}}</label>
                                </div>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-lg-6 col-md-6">
                                <div class="form-group form-float">
                                    <label class="form-label">Jewellery Name : {{$orderDetail->jewellery_name}}</label>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group form-float">
                                    <label class="form-label">Description : </label>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-lg-3 col-md-3">
                                <div class="form-group form-float">
                                    <label class="form-label">Weight : {{$orderDetail->weight}} - {{$orderDetail->weight_type}}</label>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-3">
                                <div class="form-group form-float">
                                    <label class="form-label">Current Rate : ₹ {{$orderDetail->current_rate}}</label>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-3">
                                <div class="form-group form-float">
                                    <label class="form-label">Making Charge : ₹ {{$orderDetail->making_charge}}</label>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-3">
                                <div class="form-group form-float">
                                    <label class="form-label">Other Charge : ₹ {{$orderDetail->other_charge}}</label>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    
                                    <label class="custom-label font-w-bold">Total Cost : ₹ <span class="totalCost">{{$orderDetail->total_cost}}</span></label>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    
                                    <img src="{{$orderDetail->design_image}}" class="fixed-width-height" />
                                </div>
                            </div>

                        </div>

                        

                        <div class="row">
                            <div class="col-md-4 offset-md-2">
                                <div class="form-group form-float">
                                    <a href="{{route('orders.index')}}" class="btn btn-raised btn-primary waves-effect m-t-20">back</a>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

