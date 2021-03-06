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
            <li class="{{ request()->is('admin/loans*') ? 'active' : '' }}"> <a href="{{route('loans.index')}}"><i class="zmdi zmdi-nfc"></i><span>Loans</span> </a> </li>
            
        </ul>
    </div>
    <!-- #Menu --> 
</aside>    

