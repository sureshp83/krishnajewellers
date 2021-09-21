@extends('admin.layout.index')
@section('title') Customers @endsection
@section('css')
<link rel="stylesheet" href="{{ url('admin-assets/plugins/select2/dist/css/select2.css') }}" />
@endsection
@section('content')
<section class="content">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2> {{!empty($customerDetail) ? 'Edit' : 'Add'}} Customer
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
                        @if(empty($customerDetail))
                        <form class="form" name="createCustomer" id="createCustomer" method="post" enctype="multipart/form-data" action="{{ route('customers.store') }}">
                            @else
                            <form class="form" name="updateCustomer" id="updateCustomer" action="{{ route('customers.update', ['customer' => $customerDetail->id])}}" method="POST" enctype="multipart/form-data">
                                @method('PUT')
                                @endif

                                {{ csrf_field() }}
                                <input type="hidden" name="customerId" id="customerId" value="{{$customerDetail->id ?? ''}}">


                                <div class="row">
                                    
                                    <div class="col-lg-4 col-md-4">
                                        <div class="form-group form-float">
                                            <div class="form-line focused">

                                                <label class="form-label">First Name</label>
                                                <input type="text" class="form-control" name="first_name" id="first_name" required="" placeholder="" data-parsley-required-message="Please enter first name" value="{{$customerDetail->first_name ?? ''}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <div class="form-group form-float">
                                            <div class="form-line focused">
                                                <label class="form-label">Last Name</label>
                                                <input type="text" class="form-control" name="last_name" id="last_name" required="" placeholder="" data-parsley-required-message="Please enter last name" value="{{$customerDetail->last_name ?? ''}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <div class="form-group form-float">
                                            <div class="form-line focused">
                                                <label class="form-label">Email (Optional)</label>
                                                <input type="email" class="form-control" name="email" id="email" required="" placeholder="" data-parsley-required-message="Please enter school email" value="{{$customerDetail->email ?? ''}}">
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>

                                <div class="row">
                                    
                                    <div class="col-lg-4 col-md-4">
                                        <div class="form-group form-float">
                                            <div class="form-line focused">

                                                <label class="form-label">Phone Number</label>
                                                <input type="tel" name="phone_number" class="number form-control" placeholder="" id="phone_number" value="{{ $customerDetail->phone_number ?? ''}}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-4">
                                        <div class="form-group form-float">
                                            <div class="form-line focused">

                                                <label class="form-label">Alternate Phone Number</label>
                                                <input type="tel" name="alternate_phone_number" class="number form-control" placeholder="" id="alternate_phone_number" value="{{$customerDetail->alternate_phone_number ?? ''}}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-4">
                                        <div class="form-group form-float">
                                            <div class="form-line focused">

                                                <label class="form-label">Village Name</label>
                                                <input type="text" name="village_name" class=" form-control" placeholder="" id="village_name" value="{{$customerDetail->village_name ?? ''}}">
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                   <div class="col-lg-6 col-md-6">
                                        <div class="form-group form-float">
                                            <div class="form-line focused">
                                                <label class="form-label">Address</label>
                                                <input class="form-control" type="text" id="address" name="address" value="{{$customerDetail->address ?? ''}}" placeholder="" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group form-float">
                                            <div class="form-line focused">
                                                <label class="form-label">Description</label>
                                                <textarea rows="10" cols="10" class="form-control no-resize auto-growth" name="description">{{$customerDetail->description ?? ''}}</textarea>
                                                
                                            </div>
                                        </div>    
                                    </div>   
                                    
                                </div>

                                

                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label class="custom-label">Customer Profile Image</label>
                                            <div class="text-center preview_holder">
                                                <img id="imagePreview" class="img-responsive img-thumbnail" />
                                            </div>
                                            <div class="text-center m-b-10">
                                                <div class="form-group text-center">
                                                    <div class="">
                                                        <span class="btn g-bg-blue waves-effect m-b-15 btn-file">
                                                            Change <input type="file" id="profile_image" name="profile_image"  data-value="{{$customerDetail->profile_image ?? ''}}" class="filestyle" data-parsley-pattern="[^.]+(.png|.jpg|.jpeg|.PNG|.JPG|.JPEG)$" data-parsley-pattern-message="Please upload image with valid extension" data-parsley-trigger="change" data-parsley-errors-container=".school_logo_error" />
                                                        </span>

                                                    </div>
                                                    <label id="profile_image-error" class="error" for="profile_image" style="display: none;">Please select profile image</label>
                                                    <span class="profile_image_error"></span>
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


    jQuery.validator.addMethod("lettersonly", function(value, element) {
      return this.optional(element) || /^[a-zA-Z\s]+$/i.test(value);
    }, "Please enter only letters"); 

    function checkFileExtention()
    {  
        if($('#profile_image').val() != "")
        {
            var ext = $('#profile_image').val().split('.').pop().toLowerCase();
        }
        else{
            var ext = $('#profile_image').data('value').split('.').pop().toLowerCase();
        }
        
        if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
            $('#profile_image-error').text('Please upload image with valid extention (gif,png,jpg,jpeg)');
            $('#profile_image-error').show();
            return false;
        }

        return true;
    }

       

    $(".form").validate({
        rules: {
            
            first_name: {
                required: true,
                lettersonly: true,
            },
            last_name: {
                required: true,
                lettersonly: true,
            },
            email: {
                required: false
            },
            village_name : {
                required: true,
                lettersonly: true,
            },
            phone_number: {
                required: true,
                maxlength: 12,
                minlength: 10,
                //number : true,
            },
            alternate_phone_number: {
                required: false,
                maxlength: 12,
                minlength: 10,
                //number : true,
            },
            address: {
                required: true,
            },
            description : {
                required: false,
            },
            
            profile_image: {
                required: false,
            }
            // "schoolSubjects[]": { 
            //         required: true, 
            //         minlength: 1 
            // } 
        },
        messages: {
            
            first_name: {
                required: 'Please enter first name',
            },
            last_name: {
                required: 'Please enter last name',
            },
            email: {
                required: 'Please enter email address',
                remote: 'This email address already exist'
            },
            village_name : {
                required: 'Please enter village name'
            },
            phone_number: {
                required: 'Please enter phone number',
                maxlength: 'Phone number must be less than {0} characters',
                minlength: 'Phone number must be greater than {0} characters',
                number: 'Please enter only digits'
            },
            address: {
                required: 'Please enter address',
            },
            
            description : {
                required: 'Please enter desciption',
            },
            
            profile_image: {
                required: 'Please select profile image',
            }
        },
        submitHandler: function (form){   
               
                if($('#profile_image').val() != "")
                {
                    checkFileExtention();
                }
                form.submit();
                
        }
    });
    
    @if(!empty($customerDetail))
        $("#imagePreview").css("background-image", "url({{$customerDetail->profile_image}})");
    @endif
    
    $("#profile_image").change(function() {
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