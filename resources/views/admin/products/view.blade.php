@extends('admin.layout.index')
@section('title') Products @endsection

@section('css')
<link rel="stylesheet" href="{{ url('admin-assets/css/ecommerce.css') }}" />
@endsection

@section('content')
<section class="content profile-page">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2>Product Detail
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
                <div class="card">
                    <!-- View -->
                    <div class="body">
                        <div class="row">

                            <div class="col-lg-12">
                            
                                <a href="{{route('products.edit',['product' => $productDetail->id])}}" class="btn btn-primary m-t-20 float-right" >Edit</a>
                                <a href="{{route('products.index')}}" class="btn btn-primary m-t-20 float-right">Back</a>

                                <div class="card">
                                    <!-- View -->
                                    <div class="body">

                                        <div class="row clearfix">

                                            <div class="details col-lg-8 col-md-12">
                                                <label class="custom-label">Product ID : {{$productDetail->product_id}}</label>

                                                <label class="custom-label">Product ID : {{$productDetail->product_name}}</label>

                                                <label class="custom-label">Category : {{$productDetail->category}}</label>

                                                <label class="custom-label">QR Code : </label>

                                                <img src="{{$productDetail->qr_code_image}}" class="fixed-w-h-qrcode" />
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>



                        </div>
                    </div>
                </div>
                <!-- End View -->
            </div>


            <div class="col-lg-12">
                <div class="card">
                    <!-- View -->
                    <div class="body">
                        <h4>Description</h4>
                        <div class="row clearfix">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="custom-control">{{$productDetail->description}} </label>
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

@section('js')

@endsection