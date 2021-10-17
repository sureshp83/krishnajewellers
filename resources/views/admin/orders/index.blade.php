@extends('admin.layout.index')
@section('title') Orders @endsection

@section('content')
<section class="content">
<div class="block-header">
    <div class="row">
        <div class="col-lg-7 col-md-6 col-sm-12">
            <h2>Orders List
            </h2>
        </div>
        <div class="col-lg-5 col-md-6 col-sm-12">
            <ul class="breadcrumb float-md-right">
                <li class="breadcrumb-item"><a href="{{ route('adminDashboard') }}"><i class="zmdi zmdi-home"></i> Home</a></li>
            </ul>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-lg-12">
            <!-- Table -->
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="card">
                            <div class="body">
                                @include('admin.common.flash')
                                <div class="table-responsive">
                                <table id= "orders" class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Order ID</th>
                                        <th>Customer Name</th>
                                        <th>Category</th>
                                        <th>Jew Name</th>
                                        <th>Total Cost</th>
                                        <th>Order Date</th>
                                        <th>Order Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   
                                </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Order ID</th>
                                        <th>Customer Name</th>
                                        <th>Category</th>
                                        <th>Jew Name</th>
                                        <th>Total Cost</th>
                                        <th>Order Date</th>
                                        <th>Order Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </tfoot>
                                </table>    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <!-- End Table -->
            @include('admin.common.footer_detail')      
    </div>
             
    </div>

    
</div>


</div>
</section>  
@include('admin.common.forms')                        
@endsection

@section('js')
<script>
    var table;
    $(function(){
        
        table = $('#orders').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'csv', 'print',
                {
                text: 'Add',
                action: function ( e, dt, node, config ) {
                    window.location.href = "{{route('orders.create')}}"
                }
            }
            ],
            processing: true,
            serverSide: true,
            "ajax" : {
                "url" : '{{ url( route("orders.search") ) }}',
                "type" : 'post',
                'async' : false
            },
            columns : [
                {data : 'id', name : 'id', visible:false},
                {data : 'unique_order_id', name : 'unique_order_id'},
                {data : 'customer_name', name : 'customer_name'},
                {data : 'category_name', name : 'category_name'},
                {data : 'jewellery_name', name : 'jewellery_name'},
                {data : 'total_cost', name : 'total_cost'},
                {data : 'created_date', name : 'created_date'},
                {data : 'status', name : 'status'},
                {data : 'action', name : 'action', orderable: false}
            ],

            "aaSorting": [[0,'desc']],
        });
    });

    

</script>

@endsection
