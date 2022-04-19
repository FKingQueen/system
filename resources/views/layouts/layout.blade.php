<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>I-Crop</title>
    
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @yield('css')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.min.js" integrity="sha512-vBmx0N/uQOXznm/Nbkp7h0P1RfLSj0HQrFSzV8m7rOGyj30fYAOKHYvCNez+yM8IrfnW0TCodDEjRqf6fodf/Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <link rel="stylesheet" href="https://adminlte.io/themes/v3/plugins/toastr/toastr.min.css">
    
    <script src="{{ asset('js/app.js') }}"></script>

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
                    <div class="ml-1 p-1 image">
                        <a href="{{ route('farmerList') }}">
                            <img src="{{ asset('images/logo.png')}}" width="100%" height="100%" alt="Image" >  
                        </a>
                    </div>
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
                                    Farmer History
                                </p>
                                </a>
                            </li>
                            <!-- /Farmer List Button -->
                            <!-- Crop Calendar Button -->          
                            <li class="nav-item">
                                <a type="button"href="{{ route('cropCalendar') }}" class="nav-link {{ route('cropCalendar') == url()->current() ||  route('yearform') == url()->current()  ? 'active' : '' }} ">
                                <i class="fas fa-lg fa-calendar-alt"></i>
                                <p>
                                   Crop Calendar
                                </p>
                                </a>
                            </li>
                            <!-- /Crop Calendar Button -->

                            <!-- Crop Monitoring Button -->          
                            <li class="nav-item">
                                <a type="button"  data-toggle="{{ route('cropMonitoring') == url()->current() ? '' : 'modal' }}" data-target="#cropMonitoring" class="nav-link {{ route('cropMonitoring') == url()->current() ||  route('cropMonitoringsearch') == url()->current() ? 'active' : '' }} ">
                                <i class="fas fa-lg fa-leaf"></i>
                                <p>
                                   Crop Monitoring
                                </p>
                                </a>
                            </li>
                            <!-- /Crop Monitoring Button -->

                            <!-- Yield Monitoring Button -->          
                            <li class="nav-item">
                                <a type="button" data-toggle="{{ route('yieldMonitoring') == url()->current() ? '' : 'modal' }}" data-target="#yieldMonitoring" class="nav-link {{ route('yieldMonitoring') == url()->current() || route('yieldMonitoringsearch') == url()->current() ? 'active' : '' }} ">
                                <i class="fas fa-lg fa-chalkboard"></i>
                                <p>
                                   Yield Monitoring
                                </p>
                                </a>
                            </li>
                            <!-- /Crop Monitoring Button -->
                            
                            @endif
                            

                            <!-- Account Setting Button -->          
                            <li class="nav-item ">
                                <a type="button" data-toggle="modal" data-target="#accountSetting" class="nav-link">
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
            <strong>Copyright &copy; 2021-2022 <a class="text-info">Ilocos Norte Crop Manager</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 1.0
            </div>
            </footer>

            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
            </aside>
            <!-- /.control-sidebar -->
        </div>
        <!-- ./wrapper -->

        <!-- Update Profile Modal -->
        </div>
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
        <!-- Update Profile Modal -->
        
        <!-- UplaodPicture Modal -->
        <div class="modal fade" id="upload">
            <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-0">
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
                    <div class="modal-footer justify-content-between bg-white p-0">
                        <button type="button" class="btn btn-close" data-dismiss="modal" data-toggle="modal" data-target="#profile">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
            </div>
        </div>
        <!-- /UplaodPicture Modal -->   
        <div class="arrow-up"></div>
        <!-- Crop Monitoring Modal -->
        </div>
            <div class="modal fade rounded" id="cropMonitoring" tabindex="-1" role="dialog" aria-labelledby="classInfo" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-sm">
                    <div class="modal-content rounded">
                        <div class="modal-header p-1 d-flex justify-content-center">
                        <h4 class="modal-title ml-2 ">Select</h4>
                        </div>

                        <form action="{{ route('cropMonitoring') }}" method="GET">
                            @csrf
                            <div class="modal-body rounded bg-white p-1">
                                <div class="d-flex justify-content-center mb-3">
                                    <div>
                                        <label for="UpdateFarmer_Barangay" class="input-group">Barangay:</label>
                                        <select id="barangay" type="text" name="barangay" class="form-control form-control-sm @error('barangay') is-invalid @enderror" name="barangay" required autocomplete="barangay" autofocus>
                                        <option value="" disabled selected>--- Select Barangay ---</option>
                                        @foreach($barangays as $barangay)
                                            <option value="{{$barangay->id}}">{{$barangay->name}}</option>
                                        @endforeach
                                        </select>
                                        @error('barangay')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror          
                                    </div>

                                    <div class="ml-3 d-flex align-items-end">
                                        <button type="submit" class="btn btn-sm  btn-block btn-primary input-group"> Filter </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Crop Monitoring Modal -->

        <!-- Yield Monitoring Modal -->
        </div>
            <div class="modal fade rounded" id="yieldMonitoring" tabindex="-1" role="dialog" aria-labelledby="classInfo" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-sm">
                    <div class="modal-content rounded">
                        <div class="modal-header p-1 d-flex justify-content-center">
                        <h4 class="modal-title ml-2 ">Select</h4>
                        </div>

                        <form action="{{ route('yieldMonitoring') }}" method="GET">
                            @csrf
                            <div class="modal-body rounded bg-white p-1">
                                <div class="d-flex justify-content-center mb-3">
                                    <div>
                                        <label for="UpdateFarmer_Barangay" class="input-group">Barangay:</label>
                                        <select id="barangay" type="text" name="barangay" class="form-control form-control-sm @error('barangay') is-invalid @enderror" name="barangay" required autocomplete="barangay" autofocus>
                                        <option value="" disabled selected>--- Select Barangay ---</option>
                                        @foreach($barangays as $barangay)
                                            <option value="{{$barangay->id}}">{{$barangay->name}}</option>
                                        @endforeach
                                        </select>
                                        @error('barangay')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror          
                                    </div>

                                    <div class="ml-3 d-flex align-items-end">
                                        <button type="submit" class="btn btn-sm  btn-block btn-primary input-group"> Filter </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Yield Monitoring Modal -->

        <!-- Accout Setting modal -->
        <div class="modal fade" id="accountSetting">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Account Setting</h4>
                    </div>

                    <form method="POST" action="{{ route('updateAccount',Auth::user()->id) }}">
                        @csrf
                        <div class="modal-body">
                            
                        <!-- Update Name -->
                        <div class="input-group mb-3">
                            <label for="name" class="input-group">Name:</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" required autocomplete="name" value="{{Auth::user()->name}}">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror 
                            <div class="input-group-append">
                                <div class="input-group-text">
                                <span class="fas fa-user"></span>
                                </div>
                            </div>
                        </div>
                        <!-- /Update Name -->

                        <!-- Update Email -->
                        <div class="input-group mb-3">
                            <label for="email" class="input-group">Email:</label>
                            <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" required autocomplete="email" value="{{Auth::user()->email}}">
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror 
                            <div class="input-group-append">
                                <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>
                        <!-- /Update Email -->

                        <!-- Change Password -->
                        <div class="input-group mb-3">
                            <label for="password" class="input-group">Password:</label>
                            <button type="Button" class="btn btn-close" data-dismiss="modal" data-toggle="modal" data-target="#changepass_user">
                            Change Password
                            </button>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <!-- /Change Password -->

                        </div>
                        <div class="modal-footer justify-content-between">
                            <a  class="btn btn-close"  data-dismiss="modal">Close</a>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>

                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- / Account Setting modal -->

        <!-- Change Password Modal -->
        <div class="modal fade" id="changepass_user">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                    <h4 class="modal-title">Changing Password</h4>
                    </div>

                    <form method="POST" action="{{ route('updatePassword',Auth::user()->id) }}">
                    @csrf
                    <div class="modal-body">


                        <!-- Update Password -->
                        <div class="input-group mb-3">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="New Password">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror 
                            <div class="input-group-append">
                                <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <!-- /Update Password -->
                        <!-- Update Retype Password -->
                        <div class="input-group mb-3">
                            <input id="password_confirmation" type="password" class="form-control @error('password') is-invalid @enderror" name="password_confirmation"  required autocomplete="new-password" placeholder="Retype New Password">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror 
                            <div class="input-group-append">
                                <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <!-- /Update Retype Password -->
                    </div>

                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-close" data-dismiss="modal" data-toggle="modal" data-target="#accountSetting">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /Change Password Modal -->
        
    </div>
@else
    <div class="d-flex justify-content-center content">
            @yield('content')
    </div>
@endif


    
    <!-- SweetAlert2 -->
    <script src="https://adminlte.io/themes/v3/plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="https://adminlte.io/themes/v3/plugins/toastr/toastr.min.js"></script>

    @if(Session::has('yieldmonitorfailed') && route('yieldMonitoring') != url()->current())
    <script>
    $(function() {
        $('#yieldMonitoring').modal('show');
    });
    </script>
    @endif

    <script>
        var btn = $('#button');
        $(window).scroll(function() {
        if ($(window).scrollTop() > 300) {
            btn.addClass('show');
        } else {
            btn.removeClass('show');
        }
        });

        btn.on('click', function(e) {
        e.preventDefault();
        $('html, body').animate({scrollTop:0}, '300');
        });


    </script>

    <script>
        $(function() {
            var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: true,
            timer: 3000
            });

            //FarmerList Notifications

            @if(Session::has('createdfarmer'))
                $(function() {
                    toastr.success('New Farmer is Successfully Added')
                });
            @endif
            @if(Session::has('createfarmerfailed'))
                $(function() {
                    toastr.warning('Something is Wrong, Try to Check')
                });
            @endif

            @if(Session::has('updatedfarmer'))
                $(function() {
                    toastr.success('Farmer Information Updated')
                });
            @endif
            @if(Session::has('updatefarmerfailed'))
                $(function() {
                    toastr.warning('Nothing to Change')
                });
            @endif

            @if(Session::has('deletedfarmer'))
                $(function() {
                    toastr.error('Farmer Successfully Deleted')
                });
            @endif
            @if(Session::has('deletefarmerfailed'))
                $(function() {
                    toastr.warning('Something is Wrong, Try to Check')
                });
            @endif

            //FarmerList Notifications

            //FarmerProfile Notifications

            @if(Session::has('createdfarming'))
                $(function() {
                    toastr.success('Farming Activity Successfully Created')
                });
            @endif
            @if(Session::has('createfarmingfailed'))
                $(function() {
                    toastr.warning('Something is Wrong, Try to Check')
                });
            @endif

            @if(Session::has('updatedfarming'))
                $(function() {
                    toastr.success('Farming Activity Successfully Updated')
                });
            @endif
            @if(Session::has('updatefarmingfailed'))
                $(function() {
                    toastr.warning('Nothing to Change')
                });
            @endif

            @if(Session::has('deletedfarming'))
                $(function() {
                    toastr.error('Farmer Successfully Deleted')
                });
            @endif
            @if(Session::has('deletefarmingfailed'))
                $(function() {
                    toastr.warning('Something is Wrong, Try to Check')
                });
            @endif

            // FarmerProfile Notifications
            
            // Crop Monitoring Notifications
            @if(Session::has('cropmonitorfailed'))
                $(function() {
                    toastr.warning('There is no data or information available for the specified options')
                });
            @endif
            // Crop Monitoring Notifications

            // yield Monitoring Notifications
            @if(Session::has('yieldmonitorfailed'))
                $(function() {
                    toastr.warning('There is no data or information available for the specified options')
                });
            @endif
            // yield Monitoring Notifications

            // Account Setting Notifications
            @if(Session::has('accountUpdated'))
                $(function() {
                    toastr.success('Account Setting is Succesfully Updated')
                });
            @endif
            @if(Session::has('accountUpdatedfailed'))
                $(function() {
                    toastr.error('Nothing Change')
                });
            @endif

            @if(Session::has('passwordUpdated'))
                $(function() {
                    toastr.success('Password is Succesully Changed')
                });
            @endif

            // Account Setting Notifications
        });

    </script>

    @error('password') 
        <script>
            $(function() {
                $('#changepass_user').modal('show');
            });
        </script>
    @enderror


    <script type="text/javascript">

      $(document).ready(function() {
          $('select[name="municipality"]').on('change', function() {
              var municipalityID = $(this).val();
              if(municipalityID) {
                  $.ajax({
                      url: '/farmerList/ajax/'+municipalityID,
                      type: "GET",
                      dataType: "json",
                      success:function(data) {

                          
                          $('select[name="barangay"]').empty();
                          $.each(data, function(key, value) {
                              $('select[name="barangay"]').append('<option value="'+ key +'">'+ value +'</option>');
                          });


                      }
                  });
              }else{
                  $('select[name="barangay"]').empty();
              }
          });
      });
    </script>


    
    <!-- jQuery -->
    @yield('js')
    
</body>
</html>

