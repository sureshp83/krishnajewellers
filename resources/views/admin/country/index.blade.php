@extends('admin.layout.index')
@section('title') Country @endsection

@section('content')
<section class="content">
<div class="block-header">
    <div class="row">
        <div class="col-lg-7 col-md-6 col-sm-12">
            <h2>Country List
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
                                
                                <table id= "country" class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Short Name</th>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <!-- <th>Action</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                   
                                </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Short Name</th>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <!-- <th>Action</th> -->
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
        
        table = $('#country').DataTable({
            // dom: 'Bfrtip',
            // buttons: [
            //     'copy', 'csv', 'excel', 'pdf', 'print',
            //     {
            //     text: 'Add',
            //     action: function ( e, dt, node, config ) {
            //         window.location.href = "{{route('categories.create')}}"
            //     }
            // }
            // ],
            processing: true,
            serverSide: true,
            "ajax" : {
                "url" : '{{ url( route("countries.search") ) }}',
                "type" : 'post',
                'async' : false
            },
            columns : [
                
                {data : 'id', name : 'id', orderable : false,visible:false },
                {data : 'sortname', name : 'sortname', orderable : false },
                {data : 'name', name : 'name'},
                {data : 'status', name : 'is_active'},
                // {data : 'action', name : 'action', orderable: false}
            ],

            "aaSorting": [[3,'desc']],
        });
    });

    

</script>

@endsection
