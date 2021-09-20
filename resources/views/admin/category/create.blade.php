@extends('admin.layout.index')
@section('title') Categories @endsection
@section('css')
<link rel="stylesheet" href="{{ url('admin-assets/plugins/select2/dist/css/select2.css') }}" />
@endsection
@section('content')
<section class="content">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2> {{!empty($categoryDetail) ? 'Edit' : 'Add'}} Category
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
            <div class="col-12">
                <div class="card">
                    <div class="body">
                        @if(empty($categoryDetail))
                        <form class="form" name="createCategory" id="createCategory" method="post" enctype="multipart/form-data" action="{{ route('categories.store') }}">
                        @else
                            <form class="form" name="updateCategory" id="updateCategory" action="{{ route('categories.update', ['category' => $categoryDetail->id])}}" method="POST" enctype="multipart/form-data">
                        @method('PUT')
                        @endif

                        {{ csrf_field() }}
                        <input type="hidden" name="categoryId" id="categoryId" value="{{$categoryDetail->id ?? ''}}">
                            
                            
                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <label class="custom-label">Category Name</label>
                                            <input type="text" class="form-control" name="name" id="name" required="" data-parsley-required-message="Please enter category name" value="{{$categoryDetail->name ?? ''}}">
                                        </div>
                                    </div>
                                </div>        
                            </div>

                            
                            <div class="row">
                                <div class="col-md-4 offset-md-2">
                                    <div class="form-group form-float">
                                        
                                        <button type="submit" class="btn btn-raised bg-app waves-effect m-t-20">Submit</button>
                                        <button type="reset" class="btn btn-raised btn-default waves-effect m-t-20">Cancel</button>
                                        
                                    </div>
                                </div>        
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('js')
<script src="{{ url('admin-assets/plugins/select2/dist/js/select2.min.js')}}"></script>

<script>
$("#parent_id").select2({width: '100%'}).on("change", function(e) {
             if(e.val)
             {
                 $("#parent_id option[value='"+e.val+"']").attr("selected","selected");
             }
         });

         $(".form").validate({
        rules: {
                category: {
                    required: true,
                    remote: {
                            url:url+'/check/unique/categories/category/id',
                            type: "post",
                            data: {
                                value: function() {
                                    return $( "#category" ).val();
                                },
                                id: function() {
                                   return $( "#categoryId" ).val();
                                },
                            }
                        },
                }
        },
        messages:{
            category : {
                required : 'Please enter category name',
                remote : 'This category name already exist'
            }
        }    
    });    
</script>
@endsection