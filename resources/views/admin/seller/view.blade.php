@extends('admin.layout.index')
@section('title') Sellers @endsection

@section('content')
<section class="content profile-page">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2>Seller Detail
                </h2>
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
            <div class="col-lg-12">
                <!-- View -->
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12">
                        <div class="card member-card">
                            <div class="profile-header">
                                <div class="profile_info row">
                                    <div class="col-lg-3 col-md-5 col-12">
                                        <div class="profile-image float-md-right"> <img src="{{$sellerDetail->profile_image}}" alt="" style="max-height: 200px; width: auto;"> </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-12 text-left">
                                        <h4 class="m-t-5 m-b-0"><strong>{{$sellerDetail->name}}</strong></h4>
                                        <span class="job_post"><i class="zmdi zmdi-star text-warning"></i> 0.0 | 0 reviews</span>
                                        <span class="job_post col-app font-bold">{{$sellerDetail->phone_number}}</span>
                                        <span class="job_post col-app1 font-bold">{{$sellerDetail->email}}</span>
                                        <!-- <span class="job_post">24847 Oral Prairie Apt. 125 South Twila, AK 62240-0418</span> -->

                                        <p class="social-icon m-t-20 m-b-0">
                                        </p>
                                    </div>
                                    <div class="col-lg-5 col-md-10 col-12 m-t-10">
                                        <p class="m-r-50">
                                            <!-- <iframe height="200" width="100%" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.co.in/maps?q=24847+Oral+Prairie+Apt.+125+South+Twila,+AK+62240-0418&amp;hq=Google&amp;hnear=24847+Oral+Prairie+Apt.+125+South+Twila,+AK+62240-0418&amp;ll=24.564843836677195,46.529647624428854&amp;z=15&amp;output=embed">
                                                            </iframe> -->

                                        </p>
                                    </div>
                                </div>

                            </div>

                        </div>

                        <h4 class="text-left m-l-50">Store Details</h4>


                        @foreach($sellerDetail->stores as $key => $store)
                        <div class="card">
                            <div class="row">
                                <div class="col-lg-12 col-md-12">
                                    <div class="body">
                                    <div class="profile_info row">
                                                <div class="col-lg-2 col-md-2 col-12">
                                                    <div class="profile-image "> <img src="{{$store->store_logo}}" alt="" style="max-height: 100px; width: auto;"> </div>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-12 text-left">
                                                    <h4 class="m-t-5 m-b-0"><strong>{{$store->store_name}}</strong></h4>
                                                    <span class="job_post"><i class="zmdi zmdi-star text-warning"></i> 0.0 | 0 reviews</span><br>
                                                    <span class="job_post col-app font-bold">{{$store->email}}</span><br>
                                                    <span class="job_post col-app1 font-bold">{{$store->phone_number}}</span><br>
                                                    <span class="job_post">{{$store->address}}</span>
                                                    
                                                    <p class="social-icon m-t-20 m-b-0"></p>
                                                </div> 
                                                <div class="col-lg-5 col-md-10 col-12 m-t-10">
                                                        <p class="m-r-50">
                                                            <iframe height="200" width="100%" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.co.in/maps?q=24847+Oral+Prairie+Apt.+125+South+Twila,+AK+62240-0418&amp;hq=Google&amp;hnear=24847+Oral+Prairie+Apt.+125+South+Twila,+AK+62240-0418&amp;{{$store->latitude}},{{$store->longitude}}&amp;z=15&amp;output=embed">
                                                            </iframe>
                                                        </p>
                                                </div>               
                                            </div>
                                        
                                        <hr>
                                        <div class="row">
                                            <div class="col-12">
                                                <h4 class="text-left ">We Provide</h4>
                                                <ul class="list-unstyled text-left m-l-30">
                                                    @foreach($store->storeCategories as $k => $storeCate)
                                                    <li class=" m-b-10">
                                                        <div class="row">
                                                            <div class="col-2">
                                                                <p class="font-15 font-bold col-app1">{{$storeCate->category}}</p>
                                                            </div>
                                                            <div class="col-4 text-right">
                                                                <p class="col-grey">1-4</p>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                        
                                        
                                    </div>
                                    <hr>
                                </div>
                                
                                <div class="col-lg-12 col-md-12 m-t-min-15">
                                   
                                    <div class="body">
                                    <h5 class="text-left">Store Availability</h5>
                                        <div class="row">
                                            <div class="col-12">
                                                <ul class="list-unstyled text-left">
                                                    @foreach($store->storeAvailability as $k => $available)
                                                    <li class="m-l-50">
                                                        <div class="row">
                                                            <div class="col-lg-2 col-md-2 col-2">
                                                                <p class="day-box {{($available->is_closed) ? 'bg-color-sky-blue' : ''}}">{{$available->day_name}}</p>
                                                            </div>
                                                            @if($available->is_closed != 1)
                                                            
                                                            <div class="col-lg-3 col-2">
                                                                <p class="mb-1 ">Start Time</p>
                                                                <i class="zmdi zmdi-time col-grey m-r-10"></i>
                                                                <span class="font-bold">{{$available->start_time}}</span>
                                                            </div>
                                                            <div class="col-lg-3 col-2">
                                                                <p class="mb-1 ">Start Time</p>
                                                                <i class="zmdi zmdi-time col-grey m-r-10"></i>
                                                                <span class="font-bold">{{$available->end_time}}</span>
                                                            </div>
                                                            @else
                                                            <label class="custom-label">Closed</label>
                                                            @endif
                                                        </div>
                                                    </li>
                                                    @endforeach
                                                    
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>
                <!-- End View -->
            </div>
        </div>
        @include('admin.common.footer_detail')      
    </div>
</section>
@endsection