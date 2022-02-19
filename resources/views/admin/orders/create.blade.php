@extends('admin.layout.index')
@section('title') Orders @endsection
@section('css')
<link rel="stylesheet" href="{{ url('admin-assets/plugins/select2/dist/css/select2.css') }}" />
<link rel="stylesheet" href="{{ url('admin-assets/toastr-master/toastr.css') }}" />
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
                                                <input class="form-control decimalOnly" type="text" id="weight" name="weight" value="{{$orderDetail->weight ?? ''}}" placeholder="" >
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-4">
                                        <div class="form-group form-float">
                                            <label class="custom-label">Weight Type</label>
                                            <select name="weight_type" id="weight_type" class="select2">
                                                
                                                <option value="MILIGRAM" {{(!empty($orderDetail) && $orderDetail->weight_type == "MILIGRAM") ? 'selected' : '' }}>MILIGRAM</option>
                                                <option value="GRAM" {{(!empty($orderDetail) && $orderDetail->weight_type == "GRAM") ? 'selected' : '' }}>GRAM</option>
                                                <option value="KG" {{(!empty($orderDetail) && $orderDetail->weight_type == "KG") ? 'selected' : '' }}>KG</option>
                                                
                                               
                                            </select>
                                            <label id="category_id-error" class="error" for="category_id"></label>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-3">
                                        <div class="form-group form-float">
                                            <div class="form-line focused">
                                                <label class="form-label">Current Rate</label>
                                                <input class="form-control decimalOnly" type="text" id="current_rate" name="current_rate" value="{{$orderDetail->current_rate ?? ''}}" placeholder="" >
                                            </div>
                                        </div>    
                                    </div> 
                                    
                                    <input class="form-control " type="hidden" id="calculate_value" name="calculate_value" value=""  >

                                    <div class="col-lg-3 col-md-3">
                                        <div class="form-group form-float">
                                            <div class="form-line focused">
                                                <label class="form-label">Making Charge</label>
                                                <input class="form-control decimalOnly" type="text" id="making_charge" name="making_charge" value="{{$orderDetail->making_charge ?? ''}}" placeholder="" >
                                            </div>
                                        </div>    
                                    </div> 

                                    <div class="col-lg-3 col-md-3">
                                        <div class="form-group form-float">
                                            <div class="form-line focused">
                                                <label class="form-label">Other Charge</label>
                                                <input class="form-control decimalOnly" type="text" id="other_charge" name="other_charge" value="{{$orderDetail->other_charge ?? ''}}" placeholder="" >
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
                                    
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            @php
                                            if(!empty($orderDetail))
                                            {
                                                switch($orderDetail->status)
                                                {
                                                    case 'PENDING':
                                                        $statusHtml = '<span class="label label-warning">PENDING</span>';
                                                        break;
                                                    
                                                    case 'PAYMENT_DONE':
                                                        $statusHtml = '<span class="label label-primary">PAYMENT DONE</span>';
                                                        break;
                                                        
                                                    case 'DELIVERED':
                                                        $statusHtml = '<span class="label bg-pink">DELIVERED</span>';
                                                        break;
                                                    
                                                    case 'CLOSED':
                                                        $statusHtml = '<span class="label label-success">CLOSED</span>';
                                                        break;
                                                    
                                                }
                                            }
                                            
                                            
                                            @endphp
                                            
                                            @if(!empty($orderDetail))
                                                <label class="custom-label font-w-bold">Order Status : <a data-orderid="{{$orderDetail->id}}" href="javascript:void(0);" class="btnChangeStatusDropdown">{!! $statusHtml !!}</a></label>
                                            @endif
                                        </div>
                                    </div>  

                                </div>
                                <label class="custom-label font-w-bold">Payment Detail</label>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group form-float">
                                            <label class="custom-label">Payment Type</label>
                                            <select name="payment_type" id="payment_type" class="select2">
                                                
                                                <option value="1" {{(!empty($orderDetail) && $orderDetail->payment_type == 1) ? 'selected' : '' }}>Advance Full Payment</option>
                                                <option value="2" {{(!empty($orderDetail) && $orderDetail->payment_type == 2) ? 'selected' : '' }}>Partial Payment</option>
                                                <option value="3" {{(!empty($orderDetail) && $orderDetail->payment_type == 3) ? 'selected' : '' }}>After Delivery</option>
                                                <option value="4" {{(!empty($orderDetail) && $orderDetail->payment_type == 4) ? 'selected' : '' }}>Old Jewellery</option>

                                            </select>
                                            
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6 paid_payment">
                                        <div class="form-group form-float">
                                            <div class="form-line focused">
                                                <label class="custom-label">Paid Payment</label>
                                                <input type="text" name="paid_amount" class="form-control decimalOnly" id="paid_amount" value="{{$orderDetail->paid_payment ?? ''}}" {{((!empty($orderDetail) && $orderDetail->payment_type != 3 && !empty($orderDetail->paid_payment)) ? 'disabled' : '')}}>
                                            </div>    
                                        </div>
                                    </div>
                                </div>
                                
                                @if(!empty($orderDetail))
                                <div class="row">
                                    <div class="col-lg-8 col-md-8">
                                    <label class="custom-label">Payment History</label>
                                        <table class="table">
                                            <thead>
                                                <th>Date</th>    
                                                <th>Paid Payment</th>
                                                <th>Due Payment</th>    
                                            </thead>
                                            <tbody>
                                                @foreach($orderDetail->order_payments as $key => $payment)
                                                    <tr>
                                                        <td>{{$payment->created_at}}</td>
                                                        <td>₹{{$payment->paid_amount}}</td>
                                                        <td>₹{{$payment->remain_amount}}</td>
                                                    </tr>    
                                                @endforeach
                                            </tbody>        
                                        </table>
                                    </div>
                                    
                                    @if(!in_array($orderDetail->status, ["PAYMENT_DONE","CLOSED"]))
                                    <div class="col-lg-2 col-md-2">
                                        <a href="javascript:void(0);" class="btn btn-success addMorePayment" data-orderId="{{$orderDetail->id}}">Add More Payment</a>
                                    
                                    </div>    
                                    @endif
                                </div>
                                @endif    

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
                                            <a href="{{route('orders.index')}}" class="btn btn-primary m-t-20 float-right">Back</a>
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
   
<!-- Modal -->
<div class="modal fade" id="statusChange" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      
    <form class="" id="orderStatusForm" method="post" action="{{route('orders.status')}}">    
      
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Change Order Status</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
          {{csrf_field()}}
        
        <input type="hidden" name="orderId" id="orderId" value="">

        <div class="col-lg-8 col-md-8">  
           <div class="form-group form-float">    
            
                <select class="form-control show-tick" id="orderStatus" name="orderStatus" >
                    <option value="">Please select status</option>
                    <option value="DELIVERED">DELIVERED</option>
                    <option value="PAYMENT_DONE">PAYMENT DONE</option>
                    <option value="CLOSED">CLOSED</option>
                </select>

                <label id="orderStatusError" class="error" for="" style="display: none;">Please select order status</label>
            </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>

    </form>

    </div>
  </div>
</div>
<!-- Modal -->

<div class="modal fade " id="paymentModal" tabindex="-1" role="dialog" >
    <div class="modal-dialog" role="document">
        <div class="modal-content ">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">Add Payment</h4>
            </div>
            <div class="modal-body ">
                <div class="form-group">
                    <label class="custom-label">Payment Amount</label>
                    <div class="form-line focused">
                        <input type="text" name="paid_payment" class="form-control decimalOnly" id="paid_payment">
                        <input type="hidden" name="orderId" id="orderId" value="">
                    </div>
                </div>    
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary addMorePaymentSave">SAVE</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>

@section('js')

<script src="{{ url('admin-assets/plugins/select2/dist/js/select2.min.js')}}"></script>
<!-- Flash message-->
<script src="{{ url('admin-assets/toastr-master/toastr.min.js') }}"></script>


<script>

$(document).ready(function() {

@include('admin.common.toaster_message')


});

$("#customer_id").select2({width: '100%'}).on("change", function(e) {
    if(e.val)
    {
        $("#customer_id option[value='"+e.val+"']").attr("selected","selected");
    }
});

$("#payment_type").select2({width: '100%'}).on("change", function(e) {
    if(e.val)
    {
        $("#payment_type option[value='"+e.val+"']").attr("selected","selected");
    }
});

$("#category_id").select2({width: '100%'}).on("change", function(e) {
    if(e.val)
    {
        $("#category_id option[value='"+e.val+"']").attr("selected","selected");
    }
});

$("#weight_type").select2({width: '65%'}).on("change", function(e) {
    if(e.val)
    {
        $("#weight_type option[value='"+e.val+"']").attr("selected","selected");
    }
});



$(document).on('change', '#payment_type', function(){

    $('.paid_payment').show();
    if($(this).val() == 3)
    {
        // hide paid payment if after delivery
        $('.paid_payment').hide();
    }
});

var selectedCategotry = "";

$(document).on('change', '#category_id', function(){

     selectedCategotry = $('#category_id').val();
});


$(document).on('keyup', '#current_rate', function(){
   
    
    
    // check category vise 
    if(selectedCategotry == "1")
    {
        var selectedWeightType = $('#weight_type').val();
        if(selectedWeightType == "MILIGRAM")
        {
            var divide = (parseFloat($('#weight').val()/100));
        }
        else if(selectedWeightType == "GRAM")
        {
            var divide = (parseFloat($('#weight').val()/1));    
        }
        else
        {
            var divide = (parseFloat($('#weight').val()*100));
        }
        
        var perUnitPrice = (parseFloat($('#current_rate').val()/10));
        
        var fnewTotal = (divide * perUnitPrice);
        
    }
    else
    {
        var selectedWeightType = $('#weight_type').val();
        if(selectedWeightType == "MILIGRAM")
        {
            var divide = (parseFloat($('#weight').val() / 1000));
        }
        else if(selectedWeightType == "GRAM")
        {
            var divide = (parseFloat($('#weight').val()/10));    
        }
        else
        {
            var divide = (parseFloat($('#weight').val()*10));
        }
        
        var perUnitPrice = (parseFloat($('#current_rate').val()/10));
        
        var fnewTotal = (divide * perUnitPrice);
        
    }
    
    $('#calculate_value').val(fnewTotal);

    var total = fnewTotal + parseFloat(($('#making_charge').val() != "") ? $('#making_charge').val() : 0)
     + parseFloat(($('#other_charge').val() != "") ? $('#other_charge').val() : 0);

    $('.totalCost').text((isNaN(total)) ? 0 : total);
});

$(document).on('focusout', '#current_rate', function(){
    $('#total_cost').val($('.totalCost').text());
});

$(document).on('keyup', '#making_charge', function(){
    if($(this).val() != "")
    {
        var total = parseFloat($(this).val()) + parseFloat(($('#calculate_value').val() != "") ? $('#calculate_value').val() : 0)
            + parseFloat(($('#other_charge').val() != "") ? $('#other_charge').val() : 0);
        $('.totalCost').text((isNaN(total)) ? 0 : total);
    }
});

$(document).on('focusout', '#making_charge', function(){
    $('#total_cost').val($('.totalCost').text());
});

$(document).on('keyup', '#other_charge', function(){
    if($(this).val() != "")
    {
        var total = parseFloat($(this).val()) + parseFloat(($('#calculate_value').val() != "") ? $('#calculate_value').val() : 0)
            + parseFloat(($('#making_charge').val() != "") ? $('#making_charge').val() : 0);
        $('.totalCost').text((isNaN(total)) ? 0 : total);
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
            },
            payment_type : {
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
            },
            payment_type : {
                required: 'Please select payment type'
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

    // add more payments
    $(document).on('click', '.addMorePayment', function(){

        var orderId = $(this).data('orderid');

        $('#paid_payment-error').hide();
        $('#paymentModal #orderId').val(orderId);
        $('#paymentModal').modal('show');
    });

    $(document).on('click', '#paymentModal .addMorePaymentSave', function(){
        if($('#paymentModal #paid_payment').val() == "")
        {
            $('#paid_payment-error').text('Please enter amount');
            $('#paid_payment-error').show();
            return false;
        }

        var param = {'paid_payment' : $('#paymentModal #paid_payment').val(), 'order_id' : $('#paymentModal #orderId').val()};
        $.ajax({
            url : "{{route('orders.add-more-payment')}}",
            data : param,
            type : "post",
            async : false,
            success : function(response)
            {
                if(response.code != 1)
                {
                    toastr.error(response.message,'Error');
                }
                else
                {
                    toastr.success(response.message,'Success');

                    $('#paymentModal').modal('hide');
                    setTimeout(function() {
                        location.reload();
                    }, 3000);
                }
                
                
            }
        });
    });


    $(document).on('click', '.btnChangeStatusDropdown', function(){
        
        $('#orderStatusError').hide();
        $('#statusChange').find('#filterOrderStatus').val($('#filter_order_status').val());
        $('#statusChange').find('#orderId').val($(this).data('orderid'));
        $('#statusChange').modal('show');

    });

    

    $('#orderStatusForm').validate({
        rules: {
            orderStatus : {
                required : true
            } 
        },
        messages : {
            orderStatus : {
                required : 'Please select order status'
            }
        },
        submitHandler: function (form)
        {   
            form.submit();
        }   
    });

</script>
@endsection