<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Sourcing Door | Admin Panel</title>

        <!-- Font Awesome Icons -->
        <link href="{{ asset('public/admin_asset/css/adminlte.css') }}" rel="stylesheet">
        <link href="{{ asset('public/admin_asset/css/all.min.css') }}" rel="stylesheet">
        <link href="{{ asset('public/admin_asset/css/intlTelInput.css') }}" rel="stylesheet">
        <link href="{{ asset('public/admin_asset/css/dropzone.css') }}" rel="stylesheet">
        <link href="{{ asset('public/admin_asset/css/summernote-bs4.css') }}" rel="stylesheet" type="text/css"/>
        <!-- Google Font: Source Sans Pro -->
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
        <link href="{{ asset('public/admin_asset/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css"/>
        <!-- Ion Slider -->
        <link rel="stylesheet" href="{{ asset('public/admin_asset/ion-rangeslider/css/ion.rangeSlider.min.css') }}">
        <link href="{{ asset('public/admin_asset/css/datatables.min.css') }}" rel="stylesheet" type="text/css"/>


        <link href="https://cdn.datatables.net/searchpanes/1.2.0/css/searchPanes.dataTables.min.css" rel="stylesheet" type="text/css"/>
        <link href="https://cdn.datatables.net/select/1.3.1/css/select.dataTables.min.css" rel="stylesheet" type="text/css"/>

        <script src="{{ asset('public/admin_asset/js/jquery.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>

        <!-- Ion Slider -->
        <script src="{{ asset('public/admin_asset/ion-rangeslider/js/ion.rangeSlider.min.js') }}"></script>
        <script src="{{ asset('public/admin_asset/js/intlTelInput.js') }}"></script>


        <script src="{{ asset('public/admin_asset/js/datatables.min.js') }}" type="text/javascript"></script>
        <script src="https://cdn.datatables.net/searchpanes/1.2.0/js/dataTables.searchPanes.min.js" type="text/javascript"></script>
        <script src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js " type="text/javascript"></script>

        <script src="{{ asset('public/admin_asset/js/dropzone.js') }}"></script>
        <link href="{{ asset('public/admin_asset/css/custom.css') }}" rel="stylesheet">

    </head>
    <body class="hold-transition sidebar-mini">
        <div class="wrapper">

            <!-- Navbar -->
            <nav class="main-header navbar navbar-expand navbar-white navbar-light">
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                            <i class="fas fa-bars"></i></a>
                    </li>
                    <!--                    <li class="nav-item d-none d-sm-inline-block">
                                            <a href="index3.html" class="nav-link">Home</a>
                                        </li>
                                        <li class="nav-item d-none d-sm-inline-block">
                                            <a href="#" class="nav-link">Contact</a>
                                        </li>-->
                </ul>

            </nav>
            <!-- /.navbar -->

            <!-- Main Sidebar Container -->
            <aside class="main-sidebar sidebar-dark-primary elevation-4">
                <!-- Brand Logo -->
                <a href="index3.html" class="brand-link">
<!--                    <img src="{{asset('public/img/logo.jpg')}}" alt="AdminLTE Logo" class="brand-image elevation-3"
                         style="opacity: .8">-->
                    Sourcing Door Admin
                </a>

                <!-- Sidebar -->
                <div class="sidebar">

                    <?php
                    $user = Auth::user();
                    ?>
                    <!-- Sidebar Menu -->
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                            <li class="nav-item">
                                <a href="{{url('dashboard')}}" class="nav-link">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>

                                    <p>
                                        Dashboard
                                    </p>
                                </a>
                            </li>

                            @if($user->can('view-customer'))
                            <li class="nav-item">
                                <a href="{{url('admin/customers')}}" class="nav-link">
                                    <i class="fas fa-users nav-icon"></i>
                                    <p>
                                        Customer
                                    </p>
                                </a>
                            </li>
                            @endif

                            @if($user->can('view-vendor'))
                            <li class="nav-item">
                                <a href="{{url('admin/vendors')}}" class="nav-link">
                                    <i class="fas fa-user-tie nav-icon"></i>
                                    <p>
                                        Vendors
                                    </p>
                                </a>
                            </li>
                            @endif

                            @if($user->can('view-user'))
                            <li class="nav-item">
                                <a href="{{url('admin/users')}}" class="nav-link">
                                    <i class="fas fa-users-cog nav-icon"></i>
                                    <p>
                                        Users
                                    </p>
                                </a>
                            </li>
                            @endif

                            @if($user->can('view-slider'))
                            <li class="nav-item">
                                <a href="{{url('admin/sliders')}}" class="nav-link">
                                    <i class="nav-icon fas fa-sliders-h"></i>
                                    <p>
                                        Slider
                                    </p>
                                </a>
                            </li>
                            @endif


                            @if($user->can('view-brand') || $user->can('view-category') || $user->can('view-attribute') || $user->can('view-product'))
                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-store"></i>
                                    <p>
                                        Catalog
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">

                                    @if($user->can('view-brand'))
                                    <li class="nav-item">
                                        <a href="{{url('admin/brands')}}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>
                                                Brand
                                            </p>
                                        </a>
                                    </li>
                                    @endif

                                    @if($user->can('view-category'))
                                    <li class="nav-item">
                                        <a href="{{url('admin/categories')}}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>
                                                Category
                                            </p>
                                        </a>
                                    </li>
                                    @endif

                                    @if($user->can('view-attribute'))
                                    <li class="nav-item">
                                        <a href="{{url('admin/attributes')}}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>
                                                Attribute
                                            </p>
                                        </a>
                                    </li>
                                    @endif

                                    @if($user->can('view-product'))
                                    <li class="nav-item">
                                        <a href="{{url('admin/products')}}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>
                                                Product
                                            </p>
                                        </a>
                                    </li>
                                    @endif
                                </ul>
                            </li>
                            @endif

                            @if($user->hasRole('super-admin'))
                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-user-lock"></i>
                                    <p>
                                        Role Permission
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{url('admin/roles')}}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>
                                                Roles
                                            </p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{url('permissions')}}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>
                                                Permissions
                                            </p>
                                        </a>
                                    </li>
                                </ul>

                            </li>


                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-cogs nav-icon"></i>
                                    <p>
                                        Settings
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{url('admin/types')}}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>
                                                type
                                            </p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{url('admin/units')}}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>
                                                Unit
                                            </p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{url('admin/custom-fields')}}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>
                                                Custom Field
                                            </p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{url('admin/company')}}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>
                                                Company Info
                                            </p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                            @endif

                            <li class="nav-item">
                                <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                    <i class="nav-icon fas fa-sign-out-alt"></i>
                                    <p>
                                        {{ __('Logout') }}
                                    </p>
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </li>

                        </ul>
                    </nav>
                    <!-- /.sidebar-menu -->
                </div>
                <!-- /.sidebar -->
            </aside>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <!--                            <div class="col-sm-6">
                                                            <h1 class="m-0 text-dark">Starter Page</h1>
                                                        </div> /.col 
                                                        <div class="col-sm-6">
                                                            <ol class="breadcrumb float-sm-right">
                                                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                                                <li class="breadcrumb-item active">Starter Page</li>
                                                            </ol>
                                                        </div>-->
                        </div>
                    </div>
                </div>
                <!-- /.content-header -->

                <!-- Main content -->
                <div class="content">
                    <div class="container-fluid">
                        <div class="row">

                            @yield('content')

                        </div>
                        <!-- /.row -->
                    </div><!-- /.container-fluid -->
                </div>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->

            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
                <!-- Control sidebar content goes here -->
                <div class="p-3">
                    <h5>Title</h5>
                    <p>Sidebar content</p>
                </div>
            </aside>
            <!-- /.control-sidebar -->

            <!-- Main Footer -->
            <footer class="main-footer">
                <!-- To the right -->
                <div class="float-right d-none d-sm-inline">
                    Anything you want
                </div>
                <!-- Default to the left -->
                <strong>Copyright &copy; 
                    {{date('Y', strtotime("-1 year"))}}-{{date('Y')}} 
                    <a href="https://adminlte.io">M360 Limited</a>.
                </strong> All rights reserved.
            </footer>
        </div>
        <!-- ./wrapper -->

        <!-- REQUIRED SCRIPTS -->

        <!-- jQuery -->

        <script src="{{ asset('public/admin_asset/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('public/admin_asset/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('public/admin_asset/js/adminlte.js') }}" type="text/javascript"></script>
        <script src="{{ asset('public/admin_asset/js/demo.js') }}" type="text/javascript"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
        <script src="{{ asset('public/admin_asset/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('public/admin_asset/js/summernote-bs4.min.js') }}" type="text/javascript"></script>

        <script>
                                    $(document).ready(function() {
                                    $('.select2').select2();
                                    $('.datepicker').datetimepicker({
                                    format: 'YYYY-MM-DD'
                                    });
                                    $('.timepicker').datetimepicker({
                                    format: 'LT',
                                            icons: {
                                            up: 'fa fa-angle-up',
                                                    down: 'fa fa-angle-down'
                                            },
                                    });
                                    $('#summernote').summernote({
                                    placeholder: 'Hello Bootstrap 4',
                                            tabsize: 2,
                                            height: 100,
                                            callbacks: {
                                            onImageUpload: function(files) {
                                            for (let i = 0; i < files.length; i++) {
                                            $.upload(files[i]);
                                            }
                                            }
                                            },
                                    });
                                    $('#summernote1').summernote({
                                    placeholder: 'Hello Bootstrap 4',
                                            tabsize: 2,
                                            height: 100,
                                            callbacks: {
                                            onImageUpload: function(files) {
                                            for (let i = 0; i < files.length; i++) {
                                            $.upload(files[i]);
                                            }
                                            }
                                            },
                                    });
                                    });                                  
                                    $.upload = function (file) {
                                    let out = new FormData();
                                    out.append('file', file, file.name);
                                    let image = file.name;
                                    console.log(file.name);
                                    $.ajax({
                                    headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                            method: 'POST',
                                            url: '{{url('summurnote-image-upload')}}',
                                            contentType: false,
                                            cache: false,
                                            processData: false,
                                            data: out,
                                            success: function (img) {
                                            var image = $('<img>').attr('src', img);
                                            console.log(image);
                                            $('#summernote').summernote('insertNode', image[0]);
                                            },
                                            error: function (jqXHR, textStatus, errorThrown) {
                                            console.error(textStatus + " " + errorThrown);
                                            }
                                    });
                                    };

                                    $.upload = function (file) {
                                    let out = new FormData();
                                    out.append('file', file, file.name);
                                    let image = file.name;
                                    console.log(file.name);
                                    $.ajax({
                                    headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                            method: 'POST',
                                            url: '{{url('summurnote-image-upload')}}',
                                            contentType: false,
                                            cache: false,
                                            processData: false,
                                            data: out,
                                            success: function (img) {
                                            var image = $('<img>').attr('src', img);
                                            console.log(image);
                                            $('#summernote1').summernote('insertNode', image[0]);
                                            },
                                            error: function (jqXHR, textStatus, errorThrown) {
                                            console.error(textStatus + " " + errorThrown);
                                            }
                                    });
                                    };
                                    $('#example1').DataTable();
        </script>
    </body>
</html>
