@extends('admin.layout.index')
@section('title') Loans @endsection

@section('content')
<section class="content">
<div class="block-header">
    <div class="row">
        <div class="col-lg-7 col-md-6 col-sm-12">
            <h2>Loans List
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
                                <table id= "loans" class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                    <tr>
                                        <th>#</th>  
                                        <th>Loan ID</th>
                                        <th>Customer Name</th>
                                        <th>Jewellery Cost</th>
                                        <th>Loan Amount</th>
                                        <th>Loan Issue Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   
                                </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Loan ID</th>
                                        <th>Customer Name</th>
                                        <th>Jewellery Cost</th>
                                        <th>Loan Amount</th>
                                        <th>Loan Issue Date</th>
                                        <th>Status</th>
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
        
        table = $('#loans').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'csv', 'print',
                {
                text: 'Add',
                action: function ( e, dt, node, config ) {
                    window.location.href = "{{route('loans.create')}}"
                }
            }
            ],
            processing: true,
            serverSide: true,
            "ajax" : {
                "url" : '{{ url( route("loans.search") ) }}',
                "type" : 'post',
                'async' : false
            },
            columns : [
                {data : 'id', name : 'id', visible:false},
                {data : 'unique_loan_id', name : 'unique_loan_id'},
                {data : 'customer_name', name : 'customer_name'},
                {data : 'total_jewellery_cost', name : 'total_jewellery_cost'},
                {data : 'loan_amount', name : 'loan_amount'},
                {data : 'created_date', name : 'created_date'},
                {data : 'status', name : 'status'},
                {data : 'action', name : 'action', orderable: false}
            ],

            "aaSorting": [[0,'desc']],
        });
    });

    

</script>

@endsection
