@php
 $admin = \Auth::guard('admin')->user();
 $adminImage = !empty($admin->profile_image) ? url(config('constant.ADMIN_AVATAR').$admin->profile_image) : url('images/default.jpg');
@endphp

<!-- Left Sidebar -->
<aside id="leftsidebar" class="sidebar">
    <!-- User Info -->
    <div class="user-info">
        <div class="image">
            <img src="{{$adminImage}}" width="48" height="48" alt="User" />
        </div>
        <div class="info-container">
            <div class="name" data-toggle="dropdown">{{ $admin->first_name." ".$admin->last_name}}</div>
            <div class="btn-group user-helper-dropdown">
                <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" role="button"> keyboard_arrow_down </i>
                <ul class="dropdown-menu slideUp">
                    <li><a href="{{route('editAdminProfile')}}"><i class="material-icons">person</i>Profile</a></li>
                    
                    
                    <li class="divider"></li>
                    <li><a href="{{route('adminLogout')}}"><i class="material-icons">input</i>Sign Out</a></li>
                </ul>
            </div>
            <div class="email">{{$admin->email}}</div>
        </div>
    </div>
    <!-- #User Info --> 
    <!-- Menu -->
    <div class="menu">
        <ul class="list">
            <li class="header">MAIN NAVIGATION</li>
            <li class="{{ request()->is('admin/dashboard*') ? 'active' : '' }}"> <a href="{{route('adminDashboard')}}"><i class="zmdi zmdi-home"></i><span>Dashboard</span> </a> </li>
            <li class="{{ request()->is('admin/customers*') ? 'active' : '' }}"> <a href="{{route('customers.index')}}"><i class="zmdi zmdi-accounts"></i><span>Customers</span> </a> </li>
            <li class="{{ request()->is('admin/categories*') ? 'active' : '' }}"> <a href="{{route('categories.index')}}"><i class="zmdi zmdi-book"></i><span>Categories</span> </a> </li>
            <li class="{{ request()->is('admin/products*') ? 'active' : '' }}"> <a href="{{route('products.index')}}"><i class="zmdi zmdi-card-giftcard"></i><span>Products</span> </a> </li>
            <li class="{{ request()->is('admin/orders*') ? 'active' : '' }}"> <a href="{{route('orders.index')}}"><i class="zmdi zmdi-store"></i><span>Orders</span> </a> </li>
            <li class="{{ request()->is('admin/reports*') ? 'active' : '' }}"> <a href="{{route('reports.index')}}"><i class="zmdi zmdi-nfc"></i><span>Reports</span> </a> </li>
            <li class="{{ request()->is('admin/pages*') ? 'active' : '' }}"> <a href="javascript:void(0);" class="menu-toggle waves-effect waves-block"><i class="zmdi zmdi-copy"></i><span>Pages</span></a>
                <ul class="ml-menu" style="display: none;">
                    <li class="{{ request()->is('admin/pages/aboutus*') ? 'active' : '' }}"><a href="{{route('pages.aboutus')}}" class=" waves-effect waves-block">About us</a> </li>
                    <li class="{{ request()->is('admin/pages/privacy-policy*') ? 'active' : '' }}"><a href="{{route('pages.privacy-policy')}}" class=" waves-effect waves-block">Privacy Policy</a> </li>
                    <li class="{{ request()->is('admin/pages/terms-condition*') ? 'active' : '' }}"><a href="{{route('pages.terms-condition')}}" class=" waves-effect waves-block">Terms &amp; Conditions</a> </li>
                    <li class="{{ request()->is('admin/pages/return-refund-policy*') ? 'active' : '' }}"><a href="{{route('pages.return-refund-policy')}}" class=" waves-effect waves-block">Return &amp; Refund Policy</a> </li>
                    
                </ul>
            </li>
        </ul>
    </div>
    <!-- #Menu --> 
</aside>    

