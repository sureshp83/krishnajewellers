@extends('admin.layout.index')
@section('title') Return & Refund Policy @endsection

@section('content')

<section class="content">
       <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>Return & Refund Policy</h2>
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
                            <form class="form" name="returnRefundUpdate" id="returnRefundUpdate" method="post" enctype="multipart/form-data" action="{{ route('pages.returnRefundPolicy.update') }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            
                                <textarea class="ckeditor" name="content" id="content" placeholder="Enter return & refund policy">
                                    @if(isset($returnRefund->content))
                                    {{  $returnRefund->content }}
                                    @endif
                                </textarea>
                                <label id="content-error" class="error" for="content" style="display: none;">Please enter return & refund policy</label>    
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
                required : 'Please enter return & refund policy'
            }
        }    
    });  

</script>    
@endsection