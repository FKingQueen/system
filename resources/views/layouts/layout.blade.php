<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Script Farm') }}</title>
    
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
            <aside class="main-sidebar sidebar-light-success elevation-4">
                <!-- Brand Logo -->
                <a href="index3.html" class="brand-link">
                    <span class="brand-text font-weight-light">Script Farm</span>
                </a>

                <!-- Sidebar -->
                <div class="sidebar">
                    <!-- Sidebar user panel (optional) -->
                    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                        <div class="image">
                            <img src="{{ asset('uploads/user/'.(Auth::user()->prof_image))}}" class="img-circle elevation-2" alt="User Image">
                            
                        </div>
                        <div class="info">
                            <a href="#" class="d-block" data-toggle="modal" data-target="#profile">{{Auth::user()->name}}</a>
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
                            <li class="nav-item ">
                                <a href="{{ route('userManagement') }}" class="nav-link {{ route('userManagement') == url()->current() ? 'active' : ''}}">
                                <i class="fas fa-lg fas fa-users"></i>
                                <p>
                                    User Management
                                </p>
                                </a>
                            </li>
                            <!-- /Registration Approval Button -->    

                            <!-- Registration Approval Button -->          
                            <li class="nav-item">
                                <a href="{{ route('registrationApproval') }}" class="nav-link {{ route('registrationApproval') == url()->current() ? 'active' : '' }} ">
                                <i class="fas fa-lg fa-user-check"></i>
                                <p>
                                    Registration Approval
                                </p>
                                </a>
                            </li>
                            <!-- /Registration Approval Button -->
                            @endif

                            @if(Auth::user()->role_id == 2)
                            <!-- Farmer List Button -->          
                            <li class="nav-item">
                                <a href="{{ route('farmerList') }}" class="nav-link {{ route('farmerList') == url()->current() || 'farmerProfile' ==  Route::currentRouteName() ? 'active' : '' }} ">
                                <i class="fas fa-lg fa-user-check"></i>
                                <p>
                                    Farmer List
                                </p>
                                </a>
                            </li>
                            <!-- /Farmer List Button -->

                            <!-- Crop Calendar Button -->          
                            <li class="nav-item">
                                <a href="{{ route('cropCalendar') }}" class="nav-link {{ route('cropCalendar') == url()->current() ? 'active' : '' }} ">
                                <i class="fas fa-lg fa-calendar-alt"></i>
                                <p>
                                   Crop Calendar
                                </p>
                                </a>
                            </li>
                            <!-- /Crop Calendar Button -->

                            <!-- Crop Monitoring Button -->          
                            <li class="nav-item">
                                <a href="{{ route('cropMonitoring') }}" class="nav-link {{ route('cropMonitoring') == url()->current() ? 'active' : '' }} ">
                                <i class="fas fa-lg fa-calendar-alt"></i>
                                <p>
                                   Crop Monitoring
                                </p>
                                </a>
                            </li>
                            <!-- /Crop Monitoring Button -->

                            <!-- Yield Monitoring Button -->          
                            <li class="nav-item">
                                <a href="{{ route('yieldMonitoring') }}" class="nav-link {{ route('yieldMonitoring') == url()->current() ? 'active' : '' }} ">
                                <i class="fas fa-lg fa-calendar-alt"></i>
                                <p>
                                   Yield Monitoring
                                </p>
                                </a>
                            </li>
                            <!-- /Crop Monitoring Button -->
                            
                            @endif
                            

                            <!-- Account Setting Button -->          
                            <li class="nav-item ">
                                <a type="button" href="{{ route('accountSetting') }}" class="nav-link {{ route('accountSetting') == url()->current() ? 'active' : '' }}">
                                <i class="fas fa-lg fa-cog"></i>
                                    <p>
                                        Account Setting
                                    </p>
                                </a>
                            </li>
                            <!-- /Account Setting Button -->

                            <!-- Logout Button -->
                            <li class="nav-item">
                            <a class="nav-link {{ route('logout') == url()->current() ? 'active' : '' }}"  href="{{ route('logout') }}"
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
            <div class="content-wrapper ">
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
        <!-- Update Modal -->
        <div class="modal fade" id="profile">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body ">
                <div class="image text-center">
                    <img src="{{ asset('uploads/user/'.(Auth::user()->prof_image))}}" class="img-circle w-50 img-fluid elevation-2 w-1" alt="User Image">
                </div>
                <br>
                <div class="text-center">
                    <a href="#" class="text-success text-decoration-none" data-dismiss="modal" data-toggle="modal" data-target="#upload" >Change Profile Picture</a>
                </div>
            </div>

            <div class="modal-footer justify-content-between">
            </div>
        </div>
        </div>
    </div>
    
    <!-- /UplaodPicture Modal -->
    <div class="modal fade" id="upload">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="{{ route('changeProfile',Auth::user()->id) }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body ">
                    <div class="input-group">
                        <label for="prof_image">Insert Profile Picture:</label>
                        <div class="input-group mb-3">  
                            <input id="prof_image" type="file" class="form-control @error('prof_image') is-invalid @enderror" name="prof_image" required autocomplete="prof_image">
                            @error('prof_image')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror 
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-portrait"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between ">
                    <button type="button" class="btn btn-close" data-dismiss="modal" data-toggle="modal" data-target="#profile">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
        </div>
    </div>
    <!-- /UplaodPicture Modal -->   
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

