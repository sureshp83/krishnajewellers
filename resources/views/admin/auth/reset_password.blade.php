@extends('admin.layout.authIndex')

@section('title') Admin Reset Password @endsection

@section('content')

<div class="authentication">

@include('admin.common.flash')
<div class="card">
    
    
       
        <div class="body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="header slideDown">
                        <div class="logo"><img src="{{url('admin-assets/images/logo.png')}}" width="52%" alt="JobLoopX"></div>
                        <h1>Welcome To {{config('constant.PROJECT_NAME')}} Admin</h1>
                        
                    </div>                        
                </div>
                <form class="col-lg-12" id="Resetform" method="post"  action="{{ route('admin.password.reset_process')}}">
                {{ csrf_field() }}
                <input type="hidden" name="token" id="token" value="{{ $token }}">
                    <h5 class="title">Reset Password</h5>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input class="form-control" type="email"  id="email" name="email" placeholder="" tabindex="1" required data-validation-required-message= "Please enter your email">    
                        
                            <!-- <label class="form-label">Email</label> -->
                        </div>
                    </div>

                    <div class="form-group form-float">
                        <div class="form-line">
                            <input class="form-control" type="password"  id="password" name="password" placeholder="New password" tabindex="2"> 
                        </div>
                        
                           
                        
                    </div>

                    <div class="form-group form-float">
                        <div class="form-line">
                            <input class="form-control" type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password" tabindex="3" >
                        </div>
                        
                    </div>    
                   
                    <div class="col-lg-12">
                        
                        <input type="submit" value="Save" class="btn btn-raised btn-primary waves-effect ">                  
                    </div>                     
                </form>
                
                                   
            </div>
        </div>
   
    </div>
</div>


@endsection

@section('js')

    <script src="{{ url('admin-assets/js/jquery.validate.min.js') }}" ></script>
    <script type="text/javascript">
        $(document).ready(function ()
        {
            var emailpattern = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,9}|[0-9]{1,3})(\]?)$/;

            $.validator.addMethod(
                    "regex",
                    function(value, element, regexp) {
                        var re = new RegExp(regexp);
                        return this.optional(element) || re.test(value);
                    },
                    "Please check your input."
            );

            $("#Resetform").validate({
                rules: {
                    email: {
                        required: true,
                        regex:emailpattern,
                        maxlength:150,
                    },
                    password: {
                        required: true,
                        minlength: 8,
                        maxlength:16,
                    },
                    password_confirmation: {
                        required: true,
                        equalTo: "#password"
                    }
                },
                messages: {
                    email: {
                        required: "Please enter email",
                        regex:"Please provide valid email",
                        maxlength:"Email may not be greater than {0} characters.",
                    },
                    password: {
                        required: "Please enter your password",
                        minlength: "Password must be 8 to 16 alphanumeric characters.",
                        maxlength: "Password must be 8 to 16 alphanumeric characters.",
                    },
                    password_confirmation: {
                        required: "Please enter confirm password",
                        equalTo: "Password and Confirm Password should be same"
                    }
                },
                submitHandler: function (form)
                {   
                    $('.btnReset').attr('disabled',true);
                    form.submit();
                }
            });

            $.validator.addMethod("same_value", function(value, element) {
                return $('#password').val() != $('#confirm_password').val()
            });
        });
    </script>
@endsection