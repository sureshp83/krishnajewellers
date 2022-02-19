@extends('admin.layout.index')
@section('title') Products @endsection
@section('css')
<link rel="stylesheet" href="{{ url('admin-assets/plugins/select2/dist/css/select2.css') }}" />

@endsection
@section('content')
<section class="content">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2> {{!empty($productDetail) ? 'Edit' : 'Add'}} Product
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
                        @include('admin.common.flash')
                        @if(empty($productDetail))
                        <form class="form" name="createProduct" id="createProduct" method="post" enctype="multipart/form-data" action="{{ route('products.store') }}">
                        @else
                        <form class="form" name="updateProduct" id="updateProduct" action="{{ route('products.update', ['product' => $productDetail->id])}}" method="POST" enctype="multipart/form-data">
                            @method('PUT')
                            @endif

                            {{ csrf_field() }}
                            <input type="hidden" name="productId" id="productId" value="{{$productDetail->id ?? ''}}">


                            <div class="row">

                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group form-float">
                                        <div class="form-line focused">

                                            <label class="form-label">Product Name</label>
                                            <input type="text" class="form-control" name="product_name" id="product_name" required="" value="{{$productDetail->product_name ?? ''}}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group form-float">
                                        <label class="custom-label">Category</label>
                                        <select name="category_id" id="category_id" class="select2">
                                            <option value="">Select Category</option>
                                            @forelse($categories as $category)
                                            <option value="{{$category->id}}" {{(!empty($productDetail) && $productDetail->category_id == $category->id) ? 'selected' : '' }}>{{$category->category_name}}</option>
                                            @empty
                                            <option value="">Not found</option>
                                            @endforelse
                                        </select>
                                        <label id="category_id-error" class="error" for="category_id"></label>
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group form-float">
                                        <div class="form-line focused">
                                            <label class="form-label">Description</label>
                                            <textarea rows="10" cols="10" class="form-control no-resize auto-growth" name="description">{{$orderDetail->description ?? ''}}</textarea>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 offset-md-2">
                                    <div class="form-group form-float">

                                        <button type="submit" class="btn btn-raised bg-app waves-effect m-t-20">Submit</button>
                                        <button type="reset" class="btn btn-raised btn-default waves-effect m-t-20">Cancel</button>
                                        <a href="{{route('products.index')}}" class="btn btn-primary m-t-20 float-right">Back</a>
                                    </div>
                                </div>
                            </div>


                        </form>
                    </div>
                </div>


            </div>
        </div>
        @include('admin.common.footer_detail')
    </div>
</section>

        @endsection

        @section('js')

        <script src="{{ url('admin-assets/plugins/select2/dist/js/select2.min.js')}}"></script>
       
        <script>
            

            $("#category_id").select2({
                width: '100%'
            }).on("change", function(e) {
                if (e.val) {
                    $("#category_id option[value='" + e.val + "']").attr("selected", "selected");
                }
            });



            jQuery.validator.addMethod("lettersonly", function(value, element) {
                return this.optional(element) || /^[a-zA-Z\s]+$/i.test(value);
            }, "Please enter only letters");


            $(".form").validate({
                rules: {

                    product_name: {
                        required: true,
                        lettersonly: true,
                    },
                    category_id: {
                        required: true,
                    }
                    // "schoolSubjects[]": { 
                    //         required: true, 
                    //         minlength: 1 
                    // } 
                },
                messages: {

                    product_name: {
                        required: 'Please enter product name',
                    },
                    category_id: {
                        required: 'Please select category',
                    }
                },
                submitHandler: function(form) {

                    form.submit();

                }
            });
        </script>
        @endsection