@extends('admin.layout.index')
@section('title')  About Us @endsection

@section('content')

<section class="content">
       <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>About Us</h2>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-12">
                    <ul class="breadcrumb float-md-right">
                        <li class="breadcrumb-item"><a href="{{route('adminDashboard')}}"><i class="zmdi zmdi-home"></i> Home</a></li>
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
                            <form class="form" name="aboutUsUpdate" id="aboutUsUpdate" method="post" enctype="multipart/form-data" action="{{ route('pages.aboutus.update') }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            
                                <textarea id="ckeditor" name="content" placeholder="Enter about us">
                                    @if(isset($aboutUs->content))
                                    {{  $aboutUs->content }}
                                    @endif
                                </textarea>
                                <label id="content-error" class="error" for="content" style="display: none;">Please enter about us</label>    
                        </div>
                        <div class="row">
                                <div class="col-md-4 offset-md-4">
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
        </div>
</section>
@endsection
@section('js')

<script type="text/javascript" src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
<script>   
    jQuery(document).ready(function($) {
        
        CKEDITOR.replace( 'ckeditor',{
            width: 1000,
            height: 200,
            // resize_dir: 'none',
            resize_minWidth: 200,
            resize_minHeight: 300,
            resize_maxWidth: 800
    });
    });

    $(".form").validate({
        ignore: [],
        debug: false,  
        rules: {
            content: {
                    required: function() 
                        {
                         CKEDITOR.instances.content.updateElement();
                        },
                }
        },
        messages:{
            content : {
                required : 'Please enter about us'
            }
        }    
    });  
</script>    
@endsection