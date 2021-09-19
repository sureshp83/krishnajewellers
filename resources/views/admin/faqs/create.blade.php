@extends('admin.layout.index')
@section('title') Create FAQ @endsection

@section('content')
<section class="content home">

<div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="header">
                        <h2> Create FAQ </h2>
                        
                    </div>
                @if(empty($faq))
                        <form class="form" name="createFaq" id="createFaq" method="post" enctype="multipart/form-data" action="{{ route('faqs.store') }}">
                @else
                    <form class="form" name="updateFaq" id="updateFaq" action="{{ route('faqs.update', ['faq' => $faq->id])}}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @endif
                    {{ csrf_field() }}
                    
                    <input type="hidden" name="faqId" id="faqId" value="{{$faq->id ?? ''}}">

                    <div class="body">
                        <div class="row clearfix">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="custom-label">Title</label>
                                    <div class="form-line">
                                        <input type="text" name="title" id="title" value="{{ $faq->title ?? ''}}" class="form-control" placeholder="Title">
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                        <div class="row clearfix">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="custom-label">Content</label>
                                    <div class="form-line">
                                    <textarea rows="1" class="form-control no-resize auto-growth" placeholder="Please type what you want... And please don't forget the ENTER key press multiple times :)"></textarea>
                                        <!-- <textarea name="content" rows="5" id="content" class="form-control no-resize auto-growth" placeholder="Content">{{$faq->content ?? ''}}</textarea> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row clearfix">
                            <div class="col-md-6">
                                <button class="btn btn-raised btn-primary waves-effect" type="submit">SUBMIT</button>
                            </div>
                        </div>    
                    </div>
                 </form>  
                </div>
            </div>
</div>
               
</section>

@endsection

@section('js')

<script src="{{url('admin-assets/plugins/autosize/autosize.js')}}"></script>

<script>

//Textare auto growth
    autosize($('textarea.auto-growth'));


$(".form").validate({
        rules: {
                title: {
                    required: true,
                    minlength:3,
                    remote: {
                            url:url+'/check/unique/faqs/title/id',
                            type: "post",
                            data: {
                                value: function() {
                                    return $( "#title" ).val();
                                },
                                id: function() {
                                   return $( "#faqId" ).val();
                                },
                            }
                        },
                },
                content : {
                    required: true,
                    minlength:3
                }
        },
        messages:{
            title : {
                required : 'Please enter FAQ title',
                minlength:'FAQ title must be greater than {0} characters',
                remote : 'This FAQ title already exist'
            },
            content : {
                required : 'Please enter FAQ content',
                minlength:'FAQ content must be greater than {0} characters',
            }
        }    
    });    
</script>    
@endsection