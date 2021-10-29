@extends('admin.layout.index')
@section('title') Loans @endsection
@section('css')
<link rel="stylesheet" href="{{ url('admin-assets/plugins/select2/dist/css/select2.css') }}" />
<!-- <link rel="stylesheet" href="{{ url('admin-assets/toastr-master/toastr.css') }}" /> -->
@endsection
@section('content')
<section class="content">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2> {{!empty($loanDetail) ? 'Edit' : 'Add'}} Loan
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
        <div class="">
            @include('admin.common.flash')
            @if(empty($loanDetail))
            <form class="form" name="createLoan" id="createLoan" method="post" enctype="multipart/form-data" action="{{ route('loans.store') }}">
                @else
                <form class="form" name="updateLoan" id="updateLoan" action="{{ route('loans.update', ['loan' => $loanDetail->id])}}" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                    @endif

                    {{ csrf_field() }}
                    <input type="hidden" name="loanId" id="loanId" value="{{$loanDetail->id ?? ''}}">

                    <div class="row clearfix">
                        <div class="col-12">
                            <div class="card">
                                <div class="body">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group form-float">
                                                <label class="custom-label">Customer</label>
                                                <select name="customer_id" id="customer_id" class="select2">
                                                    <option value="">Select Customer</option>
                                                    @forelse($customers as $customer)
                                                    <option value="{{$customer->id}}" {{(!empty($loanDetail) && $loanDetail->customer_id == $customer->id) ? 'selected' : '' }}>{{$customer->customer_name}}</option>
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
                                                    <option value="BOTH" {{ ((!empty($loanDetail) && $count == 2 ) ? 'selected' : '')}}>Gold & Silver</option>
                                                    @forelse($categories as $category)
                                                    <option value="{{$category->id}}" {{ ((!empty($loanDetail) && $count == 1) && (isset($keyValue) && $keyValue == $category->id)) ? 'selected' : '' }}>{{$category->category_name}}</option>
                                                    @empty
                                                    <option value="">Not found</option>
                                                    @endforelse
                                                </select>
                                                <label id="category_id-error" class="error" for="category_id"></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>                
                    </div>
                    
                    <div class="goldDetail row clearfix">
                        <div class="col-12">
                            <div class="card">
                                <div class="body">
                                    <h5>Gold Detail</h5>
                                    <div class="row">

                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group form-float">
                                                <div class="form-line focused">
                                                    <label class="form-label">Jewellery Name</label>
                                                    <input type="text" class="form-control" name="goldDetail[jewellery_name]" id="jewellery_name_gold" required="" value="{{$jewelleryData[1]['jewellery_name'] ?? ''}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group form-float">
                                                <div class="form-line focused">
                                                    <label class="form-label">Description</label>
                                                    <textarea rows="10" cols="10" name="goldDetail[description]" id="description_gold" required="" class="form-control no-resize auto-growth">{{$jewelleryData[1]['description'] ?? ''}}</textarea>

                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-lg-3 col-md-3">
                                            <div class="form-group form-float">
                                                <div class="form-line focused">
                                                    <label class="form-label">Weight</label>
                                                    <input class="form-control decimalOnly" type="text" id="weight_gold" name="goldDetail[weight]" required="" value="{{$jewelleryData[1]['weight'] ?? ''}}" placeholder="">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-3">
                                            <div class="form-group form-float">
                                                <div class="form-line focused">
                                                    <label class="form-label">Current Rate</label>
                                                    <input class="form-control decimalOnly" type="text" id="current_rate_gold" name="goldDetail[current_rate]" required="" value="{{$jewelleryData[1]['current_rate'] ?? ''}}" placeholder="">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-3">
                                            <div class="form-group form-float">
                                                <div class="form-line focused">
                                                    <label class="form-label">Applicable Amount</label>
                                                    <input class="form-control decimalOnly" type="text" id="total_cost_gold" name="goldDetail[total_cost]" required="" value="{{$jewelleryData[1]['total_cost'] ?? ''}}" placeholder="">
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="silverDetail row clearfix">
                        <div class="col-12">
                            <div class="card">
                                <div class="body">
                                    <h5>Silver Detail</h5>
                                    <div class="row">

                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group form-float">
                                                <div class="form-line focused">
                                                    <label class="form-label">Jewellery Name</label>
                                                    <input type="text" class="form-control" name="silverDetail[jewellery_name]" id="jewellery_name_silver" required="" value="{{$jewelleryData[2]['jewellery_name'] ?? ''}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group form-float">
                                                <div class="form-line focused">
                                                    <label class="form-label">Description</label>
                                                    <textarea rows="10" cols="10" class="form-control no-resize auto-growth" required="" id="description_silver" name="silverDetail[description]">{{$jewelleryData[2]['description'] ?? ''}}</textarea>

                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-lg-3 col-md-3">
                                            <div class="form-group form-float">
                                                <div class="form-line focused">
                                                    <label class="form-label">Weight</label>
                                                    <input class="form-control decimalOnly" type="text" id="weight_silver" name="silverDetail[weight]" required="" value="{{$jewelleryData[2]['weight'] ?? ''}}" placeholder="">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-3">
                                            <div class="form-group form-float">
                                                <div class="form-line focused">
                                                    <label class="form-label">Current Rate</label>
                                                    <input class="form-control decimalOnly" type="text" id="current_rate_silver" required="" name="silverDetail[current_rate]" value="{{$jewelleryData[2]['current_rate'] ?? ''}}" placeholder="">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-3">
                                            <div class="form-group form-float">
                                                <div class="form-line focused">
                                                    <label class="form-label">Applicable Amount</label>
                                                    <input class="form-control decimalOnly" type="text" id="total_cost_silver" required="" name="silverDetail[total_cost]" value="{{$jewelleryData[2]['total_cost'] ?? ''}}" placeholder="">
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row clearfix">
                        <div class="col-12">
                            <div class="card">
                                <div class="body">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group">
                                                
                                                <label class="custom-label font-w-bold">Total Applicable Amount : ₹ <span class="totalCost">{{$loanDetail->total_jewellery_cost ?? 0}}</span></label>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-3">
                                            <div class="form-group form-float">
                                                <div class="form-line focused">
                                                    <label class="form-label">Loan Amount</label>
                                                    <input class="form-control decimalOnly" type="text" id="loan_amount" required="" name="loan_amount" value="{{$loanDetail->loan_amount ?? ''}}" placeholder="">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-3">
                                            <div class="form-group form-float">
                                                <div class="form-line focused">
                                                    <label class="form-label">Loan Interest</label>
                                                    <input class="form-control decimalOnly" type="text" id="interest" required="" name="interest" value="{{$loanDetail->interest ?? ''}}" placeholder="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group">
                                                @php
                                                if(!empty($loanDetail))
                                                {
                                                switch($loanDetail->status)
                                                {
                                                case 'PENDING':
                                                $statusHtml = '<span class="label label-warning">PENDING</span>';
                                                break;

                                                case 'CLOSED':
                                                $statusHtml = '<span class="label label-success">CLOSED</span>';
                                                break;

                                                }
                                                }

                                                @endphp

                                                @if(!empty($loanDetail))
                                                <label class="custom-label font-w-bold">Order Status : <a data-orderid="{{$loanDetail->id}}" href="javascript:void(0);" class="btnChangeStatusDropdown">{!! $statusHtml !!}</a></label>
                                                @endif

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
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
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

                            <select class="form-control show-tick" id="orderStatus" name="orderStatus">
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

<div class="modal fade " id="paymentModal" tabindex="-1" role="dialog">
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
<!-- <script src="{{ url('admin-assets/toastr-master/toastr.min.js') }}"></script> -->


<script>
   

    $("#customer_id").select2({
        width: '100%'
    }).on("change", function(e) {
        if (e.val) {
            $("#customer_id option[value='" + e.val + "']").attr("selected", "selected");
        }
    });

    $("#category_id").select2({
        width: '100%'
    }).on("change", function(e) {
        if (e.val) {
            $("#category_id option[value='" + e.val + "']").attr("selected", "selected");
        }
    });

    $(document).on('change', '#category_id', function() {

        if($(this).val() == "BOTH")
        {
            $('.goldDetail').show();
            $('.silverDetail').show();
        }
        else if($(this).val() == "1") // Gold
        {
            $('.goldDetail').show();
            $('.silverDetail').hide();
        }
        else if($(this).val() == "2") // Silver
        {
            $('.goldDetail').hide();
            $('.silverDetail').show();
        }

        // // empty all data
        // $('.goldDetail').find('#jewellery_name_gold').val('');
        // $('.goldDetail').find('#description_gold').val('');
        // $('.goldDetail').find('#weight_gold').val('');
        // $('.goldDetail').find('#current_rate_gold').val('');
        // $('.goldDetail').find('#total_cost_gold').val('');

        // $('.silverDetail').find('#jewellery_name_silver').val('');
        // $('.silverDetail').find('#description_silver').val('');
        // $('.silverDetail').find('#weight_silver').val('');
        // $('.silverDetail').find('#current_rate_silver').val('');
        // $('.silverDetail').find('#total_cost_silver').val('');
    });

    @if(!empty($loanDetail))
        $('#category_id').trigger('change');
    @endif

    $(".form").validate({
        // debug:true,
        // rules: {

        //     customer_id: {
        //         required: true,
        //     },
        //     category_id: {
        //         required: true
        //     },
        //     'jewellery_name[]': {
        //         required: true
        //     },
        //     weight: {
        //         required: true
        //     },
        //     current_rate: {
        //         required: true,
        //     },
        //     payment_type: {
        //         required: true,
        //     }
        // },
        // messages: {

        //     customer_id: {
        //         required: 'Please select customer',
        //     },
        //     category_id: {
        //         required: 'Please select category',
        //     },
        //     'jewellery_name[]': {
        //         required: 'Please enter jewellery name'
        //     },
        //     weight: {
        //         required: 'Please enter jewellery weight'
        //     },
        //     current_rate: {
        //         required: 'Please enter current rate'
        //     },
        //     payment_type: {
        //         required: 'Please select payment type'
        //     }
        // },
        submitHandler: function(form) {
            form.submit();
           
        }
    });

    
    // calculate total applicable amount
    $(document).on('keyup', '#total_cost_gold', function(){
        
        var total = 0;
        if($('#total_cost_gold').val() != "")
        {
            total= parseFloat($('#total_cost_gold').val());
        }
       
        if($('#total_cost_silver').val() != "")
        {
            total+= parseFloat($('#total_cost_silver').val());
        }

        $('.totalCost').text((isNaN(total)) ? 0 : total);
    });

    $(document).on('keyup', '#total_cost_silver', function(){
        
        var total = 0;
        if($('#total_cost_silver').val() != "")
        {
            total= parseFloat($('#total_cost_silver').val());
        }
        if($('#total_cost_gold').val() != "")
        {
            total+= parseFloat($('#total_cost_gold').val());
        }
        

        $('.totalCost').text((isNaN(total)) ? 0 : total);
    });


    
    // add more payments
    $(document).on('click', '.addMorePayment', function() {

        var orderId = $(this).data('orderid');

        $('#paid_payment-error').hide();
        $('#paymentModal #orderId').val(orderId);
        $('#paymentModal').modal('show');
    });

    $(document).on('click', '#paymentModal .addMorePaymentSave', function() {
        if ($('#paymentModal #paid_payment').val() == "") {
            $('#paid_payment-error').text('Please enter amount');
            $('#paid_payment-error').show();
            return false;
        }

        var param = {
            'paid_payment': $('#paymentModal #paid_payment').val(),
            'order_id': $('#paymentModal #orderId').val()
        };
        $.ajax({
            url: "{{route('orders.add-more-payment')}}",
            data: param,
            type: "post",
            async: false,
            success: function(response) {
                if (response.code != 1) {
                   // toastr.error(response.message, 'Error');
                } else {
                    //toastr.success(response.message, 'Success');

                    $('#paymentModal').modal('hide');
                    setTimeout(function() {
                        location.reload();
                    }, 3000);
                }


            }
        });
    });


    $(document).on('click', '.btnChangeStatusDropdown', function() {

        $('#orderStatusError').hide();
        $('#statusChange').find('#filterOrderStatus').val($('#filter_order_status').val());
        $('#statusChange').find('#orderId').val($(this).data('orderid'));
        $('#statusChange').modal('show');

    });



    $('#orderStatusForm').validate({
        rules: {
            orderStatus: {
                required: true
            }
        },
        messages: {
            orderStatus: {
                required: 'Please select order status'
            }
        },
        submitHandler: function(form) {
            form.submit();
        }
    });
</script>
@endsection