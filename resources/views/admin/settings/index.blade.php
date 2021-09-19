@extends('admin.layout.index')
@section('title') Settings @endsection
@section('css')
<link rel="stylesheet" href="{{ url('admin-assets/plugins/select2/dist/css/select2.css') }}" />
@endsection
@section('content')
<section class="content slider">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2> Settings
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
            <div class="col-12">
                <div class="card">
                    <div class="body">
                    @include('admin.common.flash')
                        <form class="form" name="createSetting" id="createSetting" method="post" enctype="multipart/form-data" action="{{ route('settings.store') }}">
                            
                                {{ csrf_field() }}
                                
                                
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <label class="custom-label">Vat</label>
                                                <input type="text" class="form-control" name="vat" id="vat" required="" data-parsley-required-message="Please enter vat" value="{{(!empty($settings['vat'][0]) ? $settings['vat'][0]->value : '')}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @php
                                

                                $deliveryCharges = !empty($settings['delivery_charge']) ? $settings['delivery_charge']->keyBy('module_id')->toArray() : '';
                                
                                
                                @endphp
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group form-float">
                                            <label class="custom-label">Delivery Charge</label>
                                            <table class="table" id="delivery_charge">
                                                <thead>
                                                <th>
                                                    City
                                                </th>
                                                <th>
                                                    Delivery Charge
                                                </th>
                                                </thead>
                                                <tbody>
                                                    @foreach($cities as $key => $city)
                                                    <tr>
                                                        <td>{{$city->name}}</td>
                                                        <td>{!! '<input type="number" class="numeric" value="'.(!empty($deliveryCharges) ? (array_key_exists($city->id,$deliveryCharges) ?  $deliveryCharges[$city->id]['value'] : '') : '').'" name="delivery_charge-'.$city->id.'" id="delivery_charge-'.$city->id.'">' !!}</td>
                                                        
                                                    </tr>    
                                                    @endforeach
                                                    
                                                </tbody>    

                                            </table>    
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
    </div>
</section>
@endsection

@section('js')
<script src="{{ url('admin-assets/plugins/select2/dist/js/select2.min.js')}}"></script>

<script>

</script>
@endsection