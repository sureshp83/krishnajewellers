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
                <h2>QR Code of Products
                </h2>
                <input type="button" class="btn btn-primary m-t-20" onclick="printDiv('printableArea')" value="print" />
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
                                <div class="card">
                                    <!-- View -->
                                    <div class="body" id="printableArea">

                                        <div class="row clearfix">
                                        @foreach($qrCodes as $key => $codeImage)
                                            <div class="col-md-4 m-b-40">
                                                <span class="qr_code_print f-w-bold">{{$codeImage->product_id}}</span>
                                                <img src="{{$codeImage->qr_code_image}}">
                                            </div>    
                                            @endforeach
                                            
                                        </div>
                                    </div>
                                </div>
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

@section('js')
<script>
    function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
</script>    
@endsection