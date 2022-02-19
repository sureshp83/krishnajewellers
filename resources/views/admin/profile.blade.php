@extends('admin.layout.index')

@section('title') Admin Edit Profile @endsection
@section('css')
<link rel="stylesheet" href="{{ url('admin-assets/plugins/select2/dist/css/select2.min.css') }}">
<!-- Dropzone Css -->


@endsection

@section('content')
<section class="content ">
<div class="block-header">
    <div class="row">
        <div class="col-lg-7 col-md-6 col-sm-12">
            <h2>Edit Profile
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
        <div class="col-lg-12 col-md-12 col-sm-12">
            
               
                @include('admin.common.flash')
                  
            
            <div class="card">    
                <div class="body"> 
                    
        <!-- Tab panes -->
        <div class="tab-content">
            
            <div role="tabpanel" class="tab-pane active" id="usersettings" aria-expanded="true">
                <h2 class="card-inside-title">Security Settings</h2>
                
                <form method="post" action="{{route('updateAdminChangePassword')}}" class="form-password">
                    {{csrf_field()}}
                    <div class="row clearfix">
                        <div class="col-sm-12">
                            
                            <div class="form-group form-float">
                                <div class="form-line focused">
                                <label class="form-label">Current Password</label>
                                    <input type="password" name="current_password" id="current_password" class="form-control" >
                                </div>
                            </div>
                            <div class="form-group form-float">
                                <div class="form-line focused">
                                <label class="form-label">New Password</label>
                                    <input type="password" name="new_password" id="new_password" class="form-control" >
                                </div>
                            </div>
                            <div class="form-group form-float">
                                <div class="form-line focused">
                                <label class="form-label">Confirm Password</label>
                                    <input type="password" name="confirm_password" id="confirm_password" class="form-control" >
                                </div>
                            </div>
                            <input type="submit" class="btn btn-raised btn-primary cursor-pointer" value="Save Changes">
                        </div>
                    </div>
                </form>


        <h2 class="card-inside-title">Account Settings</h2>
            <form method="post" action="{{route('updateAdminProfile')}}" class="form-account" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <input type="hidden" name="userInfoId" id="userInfoId" value="{{$admin->id}}">
                <div class="row clearfix">
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group form-float">
                            <div class="form-line focused">
                                <label class="form-label">First Name</label>
                                <input type="text" name="first_name" id="first_name" value="{{$admin->first_name}}" class="form-control" >
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group form-float">
                            <div class="form-line focused">
                            <label class="form-label">Last Name</label>
                                <input type="text" name="last_name" id="last_name" value="{{$admin->last_name}}" class="form-control" >
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12">
                        <div class="form-group form-float">
                            <div class="form-line focused">
                            <label class="form-label">Email Address</label>
                                <input type="email" name="email" id="email" value="{{$admin->email}}" class="form-control">
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4 col-md-12">
                        <div class="form-group form-float">
                            <div class="form-line focused">
                                <label class="form-label">Phone Number</label>
                                <input type="text" name="phone_number" value="{{$admin->phone_number}}" id="phone_number" class="form-control" >
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="form-group">
                        <div class="text-center preview_holder" >
                            <img id="imagePreview" class="img-responsive img-thumbnail" />
                        </div>
                        <div class="text-center m-b-10">
                            <div class="form-group text-center">
                                <div class="">
                                <span class="btn g-bg-blue waves-effect m-b-15 btn-file">
                                Change <input type="file" id="profile_image" name="profile_image" data-value="{{$admin->profile_image ?? ''}}" class="filestyle" data-parsley-pattern="[^.]+(.png|.jpg|.jpeg|.PNG|.JPG|.JPEG)$" data-parsley-pattern-message="Please upload image with valid extension" data-parsley-trigger="change" data-parsley-errors-container=".profile_error"/>
                                </span>
                                
                                </div>
                                <label id="profile_image-error" class="error" for="profile_image" style="display: none;">Please select profile image</label>
                                <span class="profile_error"></span>
                            </div>
                        </div>
                    </div>

                   
                    <!-- <div class="col-md-12 m-t-20">
                        <div class="checkbox">
                            <label>
                                <input name="optionsCheckboxes" type="checkbox">
                                <span class="checkbox-material"><span class="check"></span></span> Profile Visibility For Everyone </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input name="optionsCheckboxes" checked="" type="checkbox">
                                <span class="checkbox-material"><span class="check"></span></span> New task notifications </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input name="optionsCheckboxes" type="checkbox">
                                <span class="checkbox-material"><span class="check"></span></span> New friend request notifications </label>
                        </div>
                    </div> -->
                    <div class="col-md-12 m-t-20">
                        <input type="submit" class="btn btn-raised btn-primary cursor-pointer" value="Save Changes">
                    </div>
                </div>
               
            </form>

            </div>
        </div>
    </div>
            </div>
        </div>
    </div>
</div>
</section>                    


@endsection

@section('js')

<script src="{{ url('admin-assets/plugins/select2/dist/js/select2.full.min.js') }}"></script>
<!-- <script src="{{ url('admin-assets/plugins/dropify/dist/js/dropify.min.js') }}"></script> -->

<script>
    $("#imagePreview").css("background-image", "url('../{{config('constant.ADMIN_AVATAR').$admin->profile_image}}')");
    //$("#imagePreview").css("background-image", "url('{{config('constant.ADMIN_AVATAR').$admin->profile_image}}')");

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
    
            reader.onload = function (e) {
                $("#imagePreview").css("background-image", "url("+e.target.result+")");
            }
    
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#profile_image").change(function () {
        readURL(this);
    });

    $('#country').select2({});

    
    $('.form-account').validate({
        debug:true,
        rules : {
            first_name : {
                required : true
            },
            last_name : {
                required : true
            },
            email : {
                required : true,
                minlength:3,
                // remote: {
                //         url:url+'/check/unique/users/email/id',
                //         type: "post",
                //         data: {
                //             value: function() {
                //                 return $( "#email" ).val();
                //             },
                //             id: function() {
                //                 return $( "#userInfoId" ).val();
                //             },
                //         }
                //     },
            },
            phone_number : {
                required : true,
                number : true,
                minlength:10,
                maxlength:15,
            },
            
            profile_image : {
                required : function (element) {
                    return ($('#profile_image').data('value') == "") ? true : false;
                },
            }
        },

        messages : {
            first_name : {
                required : 'Please enter first name'
            },
            last_name : {
                required : 'Please enter last name'
            },
            email : {
                required : 'Please enter email address',
                minlength:'Email address must be greater than {0} characters',
                remote : 'This email address already exist'
            },
            phone_number : {
                required : 'Please enter phone number',
                number : 'Please enter only digits',
                minlength:'Phone number must be greater than {0} characters',
                maxlength:'Phone number must be less than {0} characters',
            },
            
            profile_image : {
                required : 'Please select profile image',
            }
        },
        submitHandler: function (form)
            {   
                
                if(checkFileExtention())
                {
                    form.submit();
                }
                
            }
    });

    $('.form-password').validate({
       
        rules : {
            current_password : {
                required : true
            },
            new_password : {
                required : true
            },
            confirm_password : {
                required : true,
                equalTo: "#new_password"
            }
        },

        messages : {
            current_password : {
                required : 'Please enter current password'
            },
            new_password : {
                required : 'Please enter new password'
            },
            confirm_password : {
                required : 'Please enter confirm password',
                equalTo: 'Password and confirm password should be same'
            }
        }
    });


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


</script>    
@endsection