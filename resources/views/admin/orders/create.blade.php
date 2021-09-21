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
                <h2> {{!empty($orderDetail) ? 'Edit' : 'Add'}} Order
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
                        @if(empty($orderDetail))
                        <form class="form" name="createOrder" id="createOrder" method="post" enctype="multipart/form-data" action="{{ route('orders.store') }}">
                            @else
                            <form class="form" name="updateOrder" id="updateOrder" action="{{ route('orders.update', ['order' => $orderDetail->id])}}" method="POST" enctype="multipart/form-data">
                                @method('PUT')
                                @endif

                                {{ csrf_field() }}
                                <input type="hidden" name="orderId" id="orderId" value="{{$orderDetail->id ?? ''}}">


                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group form-float">
                                            <label class="custom-label">Customer</label>
                                            <select name="customer_id" id="customer_id" class="select2">
                                                <option value="">Select Customer</option>
                                                @forelse($customers as $customer)
                                                <option value="{{$customer->id}}" {{(!empty($orderDetail) && $orderDetail->customer_id == $customer->id) ? 'selected' : '' }}>{{$customer->customer_name}}</option>
                                                @empty
                                                <option value="">Not found</option>
                                                @endforelse
                                            </select>
                                            <label id="customer_id-error" class="error" for="customer_id"></label>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group form-float">
                                            <label class="custom-label">Category</label>
                                            <select name="category_id" id="category_id" class="select2">
                                                <option value="">Select Category</option>
                                                @forelse($categories as $category)
                                                <option value="{{$category->id}}" {{(!empty($orderDetail) && $orderDetail->category_id == $category->id) ? 'selected' : '' }}>{{$category->category_name}}</option>
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
                                                <label class="form-label">Jewellery Name</label>
                                                <input type="text" class="form-control" name="jewellery_name" id="jewellery_name" required="" value="{{$orderDetail->jewellery_name ?? ''}}">
                                            </div>
                                        </div>
                                    </div>
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
                                   
                                    <div class="col-lg-3 col-md-3">
                                        <div class="form-group form-float">
                                            <div class="form-line focused">
                                                <label class="form-label">Weight</label>
                                                <input class="form-control number" type="text" id="weight" name="weight" value="{{$orderDetail->weight ?? ''}}" placeholder="" >
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-3">
                                        <div class="form-group form-float">
                                            <div class="form-line focused">
                                                <label class="form-label">Current Rate</label>
                                                <input class="form-control number" type="text" id="current_rate" name="current_rate" value="{{$orderDetail->current_rate ?? ''}}" placeholder="" >
                                            </div>
                                        </div>    
                                    </div> 
                                    
                                    <div class="col-lg-3 col-md-3">
                                        <div class="form-group form-float">
                                            <div class="form-line focused">
                                                <label class="form-label">Making Charge</label>
                                                <input class="form-control number" type="text" id="making_charge" name="making_charge" value="{{$orderDetail->making_charge ?? ''}}" placeholder="" >
                                            </div>
                                        </div>    
                                    </div> 

                                    <div class="col-lg-3 col-md-3">
                                        <div class="form-group form-float">
                                            <div class="form-line focused">
                                                <label class="form-label">Other Charge</label>
                                                <input class="form-control number" type="text" id="other_charge" name="other_charge" value="{{$orderDetail->other_charge ?? ''}}" placeholder="" >
                                            </div>
                                        </div>    
                                    </div> 
                                    
                                </div>

                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <input type="hidden" name="total_cost" id="total_cost" value="{{$orderDetail->total_cost ?? ''}}">
                                            <label class="custom-label font-w-bold">Total Cost : ₹ <span class="totalCost">{{$orderDetail->total_cost ?? 0}}</span></label>
                                        </div>
                                    </div>    

                                </div>

                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label class="custom-label">Jewellery Design Image</label>
                                            <div class="text-center preview_holder">
                                                <img id="imagePreview" class="img-responsive img-thumbnail" />
                                            </div>
                                            <div class="text-center m-b-10">
                                                <div class="form-group text-center">
                                                    <div class="">
                                                        <span class="btn g-bg-blue waves-effect m-b-15 btn-file">
                                                            Change <input type="file" id="design_image" name="design_image"  data-value="{{$orderDetail->design_image ?? ''}}" class="filestyle" data-parsley-pattern="[^.]+(.png|.jpg|.jpeg|.PNG|.JPG|.JPEG)$" data-parsley-pattern-message="Please upload image with valid extension" data-parsley-trigger="change" data-parsley-errors-container=".school_logo_error" />
                                                        </span>

                                                    </div>
                                                    <label id="design_image-error" class="error" for="design_image" style="display: none;">Please select design image</label>
                                                    <span class="design_image_error"></span>
                                                </div>
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
        @include('admin.common.footer_detail')
    </div>
</section>
@endsection

@section('js')

<script src="{{ url('admin-assets/plugins/select2/dist/js/select2.min.js')}}"></script>
<script>

$("#customer_id").select2({width: '100%'}).on("change", function(e) {
    if(e.val)
    {
        $("#customer_id option[value='"+e.val+"']").attr("selected","selected");
    }
});

$("#category_id").select2({width: '100%'}).on("change", function(e) {
    if(e.val)
    {
        $("#category_id option[value='"+e.val+"']").attr("selected","selected");
    }
});

$(document).on('keyup', '#current_rate', function(){
   
    var total = parseFloat($(this).val()) + parseFloat(($('#making_charge').val() != "") ? $('#making_charge').val() : 0)
     + parseFloat(($('#other_charge').val() != "") ? $('#other_charge').val() : 0);
    
    $('.totalCost').text(total);
});

$(document).on('focusout', '#current_rate', function(){
    $('#total_cost').val($('.totalCost').text());
});

$(document).on('keyup', '#making_charge', function(){
    if($(this).val() != "")
    {
        var total = parseFloat($(this).val()) + parseFloat(($('#current_rate').val() != "") ? $('#current_rate').val() : 0)
            + parseFloat(($('#other_charge').val() != "") ? $('#other_charge').val() : 0);
        $('.totalCost').text(total);
    }
});

$(document).on('focusout', '#making_charge', function(){
    $('#total_cost').val($('.totalCost').text());
});

$(document).on('keyup', '#other_charge', function(){
    if($(this).val() != "")
    {
        var total = parseFloat($(this).val()) + parseFloat(($('#current_rate').val() != "") ? $('#current_rate').val() : 0)
            + parseFloat(($('#making_charge').val() != "") ? $('#making_charge').val() : 0);
        $('.totalCost').text(total);
    }
});

$(document).on('focusout', '#other_charge', function(){
    $('#total_cost').val($('.totalCost').text());
});

    jQuery.validator.addMethod("lettersonly", function(value, element) {
      return this.optional(element) || /^[a-zA-Z\s]+$/i.test(value);
    }, "Please enter only letters"); 

    function checkFileExtention()
    {  
        if($('#design_image').val() != "")
        {
            var ext = $('#design_image').val().split('.').pop().toLowerCase();
        }
        else{
            var ext = $('#design_image').data('value').split('.').pop().toLowerCase();
        }
        
        if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
            $('#design_image-error').text('Please upload image with valid extention (gif,png,jpg,jpeg)');
            $('#design_image-error').show();
            return false;
        }

        return true;
    }

       

    $(".form").validate({
        rules: {
            
            customer_id: {
                required: true,
            },
            category_id: {
                required: true
            },
            jewellery_name: {
                required: true
            },
            weight: {
                required: true
            },
            current_rate: {
                required: true,
            }
        },
        messages: {
            
            customer_id: {
                required: 'Please select customer',
            },
            category_id: {
                required: 'Please select category',
            },
            jewellery_name: {
                required: 'Please enter jewellery name'
            },
            weight : {
                required: 'Please enter jewellery weight'
            },
            current_rate : {
                required: 'Please enter current rate'
            }
        },
        submitHandler: function (form){   
               
                if($('#design_image').val() != "")
                {
                    checkFileExtention();
                }
                form.submit();
                
        }
    });
    
    @if(!empty($orderDetail))
        $("#imagePreview").css("background-image", "url({{$orderDetail->design_image}})");
    @endif
    
    $("#design_image").change(function() {
        readURL(this);
    });
    
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $("#imagePreview").css("background-image", "url(" + e.target.result + ")");
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection