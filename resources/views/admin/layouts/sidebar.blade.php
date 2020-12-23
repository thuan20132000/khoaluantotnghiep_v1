<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>

    </ul>

    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
        <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </form>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">



        {{-- User Controler --}}
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-user"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </li>

    </ul>
</nav>
<!-- /.navbar -->

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-scendary elevation-4">
    <!-- Brand Logo -->
    <a href="/admin" class="brand-link">
        <img src="https://vieclam24h.vn/static/img/vieclam24h_logo_meta_tag.jpg" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Việc Làm 24H</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item has-treeview menu-close">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fas fa-calendar"></i>
                        <p>
                            Danh Mục
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('category.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh Sách</p>
                            </a>
                            <a href="{{ route('category.create') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tạo Mới</p>
                            </a>

                        </li>

                    </ul>
                </li>
                <li class="nav-item has-treeview menu-close">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Lĩnh vực hoạt động
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('occupation.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh Sách</p>
                            </a>
                            <a href="{{ route('occupation.create') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tạo Mới</p>
                            </a>

                        </li>

                    </ul>
                </li>
                <li class="nav-item has-treeview menu-close">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Người Dùng
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('user.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh Sách</p>
                            </a>
                            <a href="{{ route('user.create') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tạo Mới</p>
                            </a>

                        </li>

                    </ul>
                </li>
                <li class="nav-item has-treeview menu-close">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fas fa-tasks"></i>
                        <p>
                            Quản Lý Việc Làm
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('job.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh Sách Việc Làm</p>
                            </a>
                            <a href="{{ route('job.create') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Thêm Mới Việc Làm</p>
                            </a>


                        </li>

                    </ul>
                </li>
                <li class="nav-item has-treeview menu-close">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fas fa-project-diagram"></i>
                        <p>
                            Kết Nối Việc Làm
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('jobcollaborator.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh sách đăng ký</p>
                            </a>
                            {{-- <a href="{{ route('jobconfirm.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh sách xác nhận</p>
                            </a> --}}
                        </li>
                    </ul>
                </li>


            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
