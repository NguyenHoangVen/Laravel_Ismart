<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('public/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/fontawesome/css/solid.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/admins/css/style.css') }}">
    @yield('css')
    <title>@yield('title')</title>

</head>

<body>
    @php
        $module_active = session('module_active');
    @endphp
    <div id="warpper" class="nav-fixed">
        <nav class="topnav shadow navbar-light bg-white d-flex">
            <div class="navbar-brand"><a href="{{ route('dashboard') }}">UNITOP ADMIN</a></div>
            <div class="nav-right ">
                <div class="btn-group mr-auto">
                    <button type="button" class="btn dropdown" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <i class="plus-icon fas fa-plus-circle"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ url('admin/post/add') }}">Thêm bài viết</a>
                        <a class="dropdown-item" href="{{ url('admin/product/add') }}">Thêm sản phẩm</a>
                        <a class="dropdown-item" href="{{ url('admin/user/add') }}">Thêm thành viên</a>
                    </div>
                </div>
                <div class="btn-group">
                    <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        {{ Auth::user()->name }}
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            {{ __('Thoát') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </nav>
        <!-- end nav  -->
        <div id="page-body" class="d-flex">
            <div id="sidebar" class="bg-white">
                <ul id="sidebar-menu">
                    <li class="nav-link {{ $module_active == 'dashboard' ? 'active' : '' }}">
                        <a href="{{ url('admin') }}">
                            <div class="nav-link-icon d-inline-flex">
                                <i class="far fa-folder"></i>
                            </div>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-link {{ $module_active == 'page' ? 'active' : '' }}">
                        <a href="{{ url('admin/page') }}">
                            <div class="nav-link-icon d-inline-flex">
                                <i class="far fa-file"></i>
                            </div>
                            Trang
                        </a>
                        <i class="arrow fas fa-angle-right"></i>

                        <ul class="sub-menu">
                            <li><a href="{{ url('admin/page/add') }}">Thêm mới</a></li>
                            <li><a href="{{ url('admin/page/list') }}">Danh sách</a></li>
                        </ul>
                    </li>
                    <li class="nav-link {{ $module_active == 'post' ? 'active' : '' }}">
                        <a href="{{ route('post.list') }}">
                            <div class="nav-link-icon d-inline-flex">
                                <i class="far fa-newspaper"></i>
                            </div>
                            Bài viết
                        </a>
                        <i class="arrow fas fa-angle-right"></i>
                        <ul class="sub-menu">
                            <li><a href="{{ route('post.add') }}">Thêm mới</a></li>
                            <li><a href="{{ route('post.list') }}">Danh sách</a></li>
                            <li><a href="{{ route('categoryPost.list') }}">Danh mục</a></li>
                        </ul>
                    </li>
                    <li class="nav-link {{ $module_active == 'product' ? 'active' : '' }} ">
                        <a href="{{ route('product.list') }}">
                            <div class="nav-link-icon d-inline-flex">
                                <i class="fas fa-mobile-alt"></i>
                            </div>
                            Sản phẩm
                        </a>
                        <i class="arrow fas fa-angle-down"></i>
                        <ul class="sub-menu">
                            <li><a href="{{ route('product.add') }}">Thêm mới</a></li>
                            <li><a href="{{ route('product.list') }}">Danh sách</a></li>
                            <li><a href="{{ route('category.list') }}">Danh mục</a></li>
                        </ul>
                    </li>
                    <li class="nav-link {{ $module_active == 'order' ? 'active' : '' }}">
                        <a href="{{ route('order.index') }}">
                            <div class="nav-link-icon d-inline-flex">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            Bán hàng
                        </a>
                        <i class="arrow fas fa-angle-right"></i>
                        <ul class="sub-menu">
                            <li><a href="{{ route('order.index') }}">Đơn hàng</a></li>
                        </ul>
                    </li>
                    <li class="nav-link {{ $module_active == 'user' ? 'active' : '' }}">
                        <a href="{{ url('admin/user') }}">
                            <div class="nav-link-icon d-inline-flex">
                                <i class="fas fa-users"></i>
                            </div>
                            Users
                        </a>
                        <i class="arrow fas fa-angle-right"></i>

                        <ul class="sub-menu">
                            <li><a href="{{ url('admin/user/add') }}">Thêm mới</a></li>
                            <li><a href="{{ url('admin/user/list') }}">Danh sách</a></li>
                        </ul>
                    </li>
                    <li class="nav-link {{ $module_active == 'slider' ? 'active' : '' }}">
                        <a href="{{ route('slider.list') }}">
                            <div class="nav-link-icon d-inline-flex">
                                <i class="fas fa-sliders-h"></i>
                            </div>
                            Sliders
                        </a>
                        <i class="arrow fas fa-angle-right"></i>
                    </li>
                    <li class="nav-link {{ $module_active == 'permission' ? 'active' : '' }}">
                        <a href="{{ route('permission.list') }}">
                            <div class="nav-link-icon d-inline-flex">
                                <i class="fab fa-slideshare"></i>
                            </div>
                            Quyền
                        </a>
                        <i class="arrow fas fa-angle-right"></i>
                        <ul class="sub-menu">
                            <li><a href="{{ route('permission.list') }}">Danh sách</a></li>
                            <li><a href="{{ route('groupPermission.list') }}">Nhóm quyền</a></li>
                        </ul>
                    </li>
                    <li class="nav-link {{ $module_active == 'role' ? 'active' : '' }}">
                        <a href="{{ route('role.list') }}">
                            <div class="nav-link-icon d-inline-flex">
                                <i class="fas fa-users-cog"></i>
                            </div>
                            Vai trò
                        </a>
                        <i class="arrow fas fa-angle-right"></i>
                        <ul class="sub-menu">
                            <li><a href="{{ route('role.add') }}">Thêm mới</a></li>
                            <li><a href="{{ route('role.list') }}">Danh sách</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div id="wp-content">
                @yield('content')
            </div>
        </div>


    </div>

    <script src="{{ asset('public/bootstrap/js/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('public/bootstrap/js/popper.min.js') }}"></script>
    <script src="{{ asset('public/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('public/admins/js/app.js') }}"></script>
    @yield('js')
</body>

</html>
