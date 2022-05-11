@extends('layouts.layout')

@section('css')
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://adminlte.io/themes/v3/plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="https://adminlte.io/themes/v3/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="https://adminlte.io/themes/v3/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="https://adminlte.io/themes/v3/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

  <script src="{{ asset('js/app.js') }}"></script>
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

 
  <style>
  /* floating Button */
  .float{
  position:fixed;
  width:155px;
  height:45px;
  bottom:20px;
  right:40px;
  background-color: #248139;
  border-color: #248139;
  color: #FFF;
  border-radius:50px;
  text-align: center;
  box-shadow: 2px 4px 4px #999;
  z-index: 4;
  }

  .float:hover {
    color: #fff;
    background-color: #4FB250;
    border-color: #4FB250;
  }

  .my-float{
    margin-top:15px;
  }
  </style>
@endsection

@section('content')
@if(Auth::user())

  <!-- Content Header (Page header) -->
  <div class="content-header">
      <div class="container-fluid">
      <div class="row mb-2">
          <div class="col-sm-6">
              <h1 class="m-0 farm_title">User Management</h1>
          </div>
          <!-- /.col -->
      </div><!-- /.row -->
      </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <a type="button" class="float" data-toggle="modal" data-target="#createUser">
    <i style="color:#ffffff" class="fas fa-solid fa-plus my-float"></i>
    <span style="color:#ffffff; font-size: 12pt;">Create New User</span>
  </a>
  
<!-- Create Farming Modal -->
<div class="modal fade" id="createUser">
  <div class="modal-dialog modal-dialog-centered">
  <div class="modal-content">

    <div class="modal-header bg-green p-2">
      <h4 class="modal-title">Creating New User</h4>
    </div>

        <form method="POST" action="{{ route('createUser') }}" >
          @csrf
          <div class="modal-body bg-white mt-1 mb-1">

            <div class="input-group mb-3">
              <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Full Name">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-user"></span>
                  </div>
                </div>
                @error('name')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror          
            </div>

            <div class="input-group mb-3">
              <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-envelope"></span>
                </div>
              </div>
              @error('email')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror 
            </div>

            <div class="input-group mb-3">
              <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Password">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
              @error('password')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror 
            </div>

            <div class="input-group">
              <input id="password_confirmation" type="password" class="form-control" name="password_confirmation"  required autocomplete="new-password" placeholder="Confirm">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
            </div>
          </div>

          <div class="modal-footer justify-content-around bg-white p-1">
              <button type="button" class="btn btn-close" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Create User</button>
          </div>
        </form>
  </div>
  </div>
</div>
<!-- /Create Farming Modal -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
              <table id="user"  class="table table-bordered">
                <thead>
                  <tr>
                    <th class="text-center">Role</th>
                    <th class="text-center w-100">Name</th>
                    <th class="text-center">Municipality</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody>
                @foreach($users as $user )
                  <tr>
                    @csrf
                    <td>
                      {{$user->role->name}}
                    </td>
                    <td>
                      {{$user->name}}
                    </td>
                    <td class="text-center">
                      {{$user->municipality->name}}
                    </td>
                    <td>
                      <input type="checkbox" class="toggle-class_{{$user->id}}" data-id="{{$user->id}}" data-size="sm" data-width="95"   data-onstyle="success" data-offstyle="secondary" data-toggle="toggle" data-on="Activated" data-off="Deactivated" {{ $user->acc_status ? 'checked' : '' }}>
                    
                        <script>
                          $(function() {
                            $('.toggle-class_{{$user->id}}').change(function() {
                                var status = $(this).prop('checked') == true ? 1 : 0; 
                                var yield = ('');
                                var id = $(this).data('id'); 
                                
                                $.ajax({
                                    type: 'GET',
                                    url: '/changeaccStatus',
                                    dataType: 'json',
                                    data: {'status': status, 'id': id},
                                    //success: function(data){console.log(data.success)}
                                });
                            });
                          });
                        </script>
                    </td>
                    <td>
                      
                      <button type="Button" class="p-0 btn btn-block btn-close btn-xm" data-toggle="modal" data-target="#update_{{$user->id}}">
                        Update
                      </button>
                    </td>
                  </tr>
                  </div>
                  
                  <!-- Update User Account Modal -->
                  <div class="modal fade" id="update_{{$user->id}}">
                    <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content">
                        <div class="modal-header p-2">
                            <h4 class="modal-title">User Account Setting</h4>
                        </div>

                        <form method="POST" action="{{ route('userUpdate',$user->id) }}">
                          @csrf
                          <div class="modal-body">
                            <!-- Update Name -->
                            <div class="input-group mb-3">
                                <label for="name" class="input-group">Name:</label>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" required autocomplete="name" value="{{$user->name}}">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                    </div>
                                </div>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror 
                            </div>
                            <!-- /Update Name -->

                            <!-- Update Email -->
                            <div class="input-group mb-3">
                                <label for="email" class="input-group">Email:</label>
                                <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" required autocomplete="email" value="{{$user->email}}">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                    </div>
                                </div>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror 
                            </div>
                            <!-- /Update Email -->

                            <!-- Change Password -->
                            <div class="input-group mb-3">
                              <label for="password" class="input-group">Password:</label>
                              <button type="Button" class="btn btn-close" data-dismiss="modal" data-toggle="modal" data-target="#changepass_{{$user->id}}">
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

                          <div class="modal-footer justify-content-around bg-white p-1">
                            <button type="button" class="btn btn-close" data-dismiss="modal" >Close</button> 
                            <button type="submit" class="btn btn-primary">Save changes</button>
                          </div>
                        </form>
                      </div>
                      </div>
                    </div>
                    <!-- /Update User Account Modal -->

                    <!-- Change Password Modal -->
                    <div class="modal fade" id="changepass_{{$user->id}}">
                    <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content">
                        <div class="modal-header p-2">
                          <h4 class="modal-title">Changing Password</h4>
                        </div>

                        <form method="POST" action="{{ route('userchangePassword',$user->id) }}">
                          @csrf
                          <div class="modal-body">


                            <!-- Update Password -->
                            <div class="input-group mb-3">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="New Password">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                    </div>
                                </div>
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror 
                            </div>
                            <!-- /Update Password -->
                            <!-- Update Retype Password -->
                            <div class="input-group mb-3">
                                <input id="password_confirmation" type="password" class="form-control @error('password') is-invalid @enderror" name="password_confirmation"  required autocomplete="new-password" placeholder="Retype New Password">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                    </div>
                                </div>
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror 
                            </div>
                            <!-- /Update Retype Password -->
                          </div>

                          <div class="modal-footer justify-content-around  bg-white p-1 ">
                            <button type="button" class="btn btn-close" data-dismiss="modal" data-toggle="modal" data-target="#update_{{$user->id}}">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                          </div>
                        </form>
                      </div>
                    </div>
                    </div>
                    <!-- /Change Password Modal -->

                    <script>
                      @if(Session::has('accountUpdatedfailed'))
                        $(function() {
                            $('#update_{{$user->id}}').modal('show');
                        });
                      @endif
                    </script>
                    
                @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </section>
  <!-- /.content -->

  
  
@endif
@endsection

@section('js')

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" ></script>
  <script src="{{ asset('js/app.js') }}"></script>
  <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
  

<!-- DataTables  & Plugins -->
<script src="https://adminlte.io/themes/v3/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="https://adminlte.io/themes/v3/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="https://adminlte.io/themes/v3/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="https://adminlte.io/themes/v3/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="https://adminlte.io/themes/v3/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="https://adminlte.io/themes/v3/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>

<script src="https://adminlte.io/themes/v3/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="https://adminlte.io/themes/v3/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="https://adminlte.io/themes/v3/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>


@error('email') 
    <script>
        $(function() {
            $('#createUser').modal('show');
        });
    </script>
@enderror

<script>
  $(function () {
    $('#user').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>

@endsection

