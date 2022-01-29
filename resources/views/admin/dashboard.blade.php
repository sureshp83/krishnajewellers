@extends('admin.layout.index')

@section('title') Dashboard @endsection
@section('css')

@endsection
@section('content')

<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Dashboard </h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">

                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Info box -->
    <!-- ============================================================== -->

    @include('admin.common.flash')
    <!-- Main Content -->
    <section class="content home">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>Dashboard
                        <small class="text-muted">Welcome to {{config('constant.PROJECT_NAME')}} </small>
                    </h2>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-12">
                    <ul class="breadcrumb float-md-right">
                        <li class="breadcrumb-item"><a href="{{route('adminDashboard')}}"><i class="zmdi zmdi-home"></i> Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row clearfix">

            <div class="col-lg-12">
                    <div class="row clearfix social-widget">
                        <div class="col-xl-3 col-lg-3 col-md-3">
                            <a href="{{route('customers.index')}}" class="cursor-pointer">
                            <div class="card info-box-2 hover-zoom-effect app-widget">
                                <div class="icon"><i class="zmdi zmdi-accounts"></i></div>
                                <div class="content">
                                    <div class="text">Customers</div>
                                    <div class="number">{{$totalCustomer ?? 0}}</div>
                                </div>
                            </div>
                            </a>
                        </div>

                        <div class="col-xl-3 col-lg-3 col-md-3">
                            <a href="{{route('products.index')}}" class="cursor-pointer">
                            <div class="card info-box-2 hover-zoom-effect app-widget">
                                <div class="icon"><i class="zmdi zmdi-card-giftcard"></i></div>
                                <div class="content">
                                    <div class="text">Products</div>
                                    <div class="number">{{$totalProduct ?? 0}}</div>
                                </div>
                            </div>
                            </a>
                        </div>

                        <div class="col-xl-3 col-lg-3 col-md-3">
                            <a href="{{route('orders.index')}}" class="cursor-pointer">
                            <div class="card info-box-2 hover-zoom-effect app-widget">
                                <div class="icon"><i class="zmdi zmdi-store"></i></div>
                                <div class="content">
                                    <div class="text">Orders</div>
                                    <div class="number">{{$totalOrder ?? 0}}</div>
                                </div>
                            </div>
                            </a>
                        </div>

                        <div class="col-xl-3 col-lg-3 col-md-3">
                            <a href="{{route('loans.index')}}" class="cursor-pointer">
                            <div class="card info-box-2 hover-zoom-effect app-widget">
                                <div class="icon"><i class="zmdi zmdi-nfc"></i></div>
                                <div class="content">
                                    <div class="text">Loans</div>
                                    <div class="number">{{$totalLoan ?? 0}}</div>
                                </div>
                            </div>
                            </a>
                        </div>
                        
                    </div> 
                </div>

                



                

            </div>
        </div>
    </section>
    <!-- ============================================================== -->
    <!-- End Page Content -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->

@endsection
@section('js')
<!-- Chart JS -->
<script src="{{ url('admin-assets/node_modules/morrisjs/morris.min.js') }}"></script>
<script>
</script>
@endsection