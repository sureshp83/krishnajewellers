@extends('admin.layout.index')
@section('title') Supports @endsection

@section('content')
<section class="content home">
    <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="header">
                            <h2> Supports </h2>
                            
                        </div>
                        @include('admin.common.flash')
                        <div class="col-md-12 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('adminDashboard') }}"><i class="zmdi zmdi-home"></i> Home</a>
                                </li>
                                <li class="breadcrumb-item active">Supports</li>
                            </ol>
                            <!-- <a href="{{ route('recruiters.create')}}" type="button" class="btn btn-info d-none d-lg-block m-l-15">
                                <i class="fa fa-plus-circle"></i> Create New</a> -->
                        </div>
                    </div>
                            
                         
                        <div class="body">
                            
                            <div class="table-responsive">
                                <table id="supports" class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Query</th>
                                            <th>Date</th>
                                            {{-- <th>Status</th> --}}
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
                                       
                                    </tbody>
                                </table>
                            </div>
                        </div>
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
        
        table = $('#supports').DataTable({
            processing: true,
            serverSide: true,
            "ajax" : {
                "url" : '{{ url( route("supports.search") ) }}',
                "type" : 'post',
                'async' : false
            },
            columns : [
                
                {data : 'sr_no', name : 'id', orderable : false },
                {data : 'sender_name', name : 'sender_name'},
                {data : 'support_message', name : 'support_message'},
                {data : 'createdDate', name : 'createdDate'},
                // {data : 'status', name : 'status'},
                {data : 'action', name : 'action', orderable: false}
            ],

            "aaSorting": [[0,'desc']],
        });
    });

    

</script>

@endsection