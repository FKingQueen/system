<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @yield('css')



</head>
<body class="hold-transition sidebar-mini">
@if(Auth::user())
    <div id="app">
        <div class="wrapper">
            <!-- Navbar -->
            <nav class="main-header navbar navbar-expand navbar-white navbar-light">
                
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>
            </nav>
            <!-- /.navbar -->

            <!-- Main Sidebar Container -->
            <aside class="main-sidebar sidebar-dark-primary elevation-4">
                <!-- Brand Logo -->
                <a href="index3.html" class="brand-link">
                    <span class="brand-text font-weight-light">Transcription System</span>
                </a>

                <!-- Sidebar -->
                <div class="sidebar">
                    <!-- Sidebar user panel (optional) -->
                    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                        <div class="image">
                            <img src="{{ asset('uploads/approval/'.(Auth::user()->email).'.jpg')}}" class="img-circle elevation-2" alt="User Image">
                        </div>
                        <div class="info">
                            <a href="#" class="nav-item">
                                {{ Auth::user()->name }}
                            </a>
                        </div>
                    </div>

                    <!-- Sidebar Menu -->
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                            <!-- Authentication Links -->
                            @guest

                            @else

                            @if(Auth::user()->role_id == 1)

                            <!-- Users Management Button -->          
                            <li class="nav-item">
                                <a href="{{ route('userManagement') }}" class="nav-link">
                                <i class="fas fa-lg fas fa-users"></i>
                                <p>
                                    User Management
                                </p>
                                </a>
                            </li>
                            <!-- /Registration Approval Button -->    

                            <!-- Registration Approval Button -->          
                            <li class="nav-item">
                                <a href="{{ route('registrationApproval') }}" class="nav-link">
                                <i class="fas fa-lg fa-user-check"></i>
                                <p>
                                    Registration Approval
                                </p>
                                </a>
                            </li>
                            <!-- /Registration Approval Button -->
                            @endif

                            @if(Auth::user()->role_id == 0)

                            @endif
                            

                            <!-- Account Setting Button -->          
                            <li class="nav-item">
                                <a type="button" href="{{ route('accountSetting') }}" class="nav-link">
                                <i class="fas fa-lg fa-cog"></i>
                                    <p>
                                        Account Setting
                                    </p>
                                </a>
                            </li>
                            <!-- /Account Setting Button -->

                            <!-- Logout Button -->
                            <li class="nav-item">
                                <div>
                                    <a class="nav-link"  href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                    <i class="fas fa-lg fa-sign-out-alt"></i>
                                    <p>
                                        Logout
                                    </p>
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                            <!-- /Logout Button -->
                            @endguest
                        </ul>
                    </nav>
                    <!-- /.sidebar-menu -->
                </div>
            <!-- /.sidebar -->
            </aside>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                 @yield('content')
            </div>
            <!-- /.content-wrapper -->
            <footer class="main-footer">
            <strong>Copyright &copy; 2021-2022 <a href="#">Transcription System</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 3.1.0
            </div>
            </footer>

            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
            </aside>
            <!-- /.control-sidebar -->
        </div>
        <!-- ./wrapper -->

    </div>
@else

    <div class="d-flex justify-content-center content">
            @yield('content')
    </div>
    
@endif

    <!-- jQuery -->
    <script src="{{ asset('js/app.js') }}"></script>
    
    <!-- SweetAlert2 -->
    <script src="https://adminlte.io/themes/v3/plugins/sweetalert2/sweetalert2.min.js"></script>

    @if(Session::has('success'))
        <script>
            $(function() {
                var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
                });

                $(function() {
                    $(document).Toasts('create', {
                        class: 'bg-success',
                        title: 'Account Setting Notification',
                        delay: 3000,
                        autohide: true,
                        body: 'Succesfully Change'
                    })
                });
            });
        </script>
    @endif


    @yield('js')


</body>
</html>

