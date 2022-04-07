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
                        <div class="modal-header">
                            <h4 class="modal-title">User Account Setting</h4>
                        </div>

                        <form method="POST" action="{{ route('userUpdate',$user->id) }}">
                          @csrf
                          <div class="modal-body">
                            <!-- Update Name -->
                            <div class="input-group mb-3">
                                <label for="name" class="input-group">Name:</label>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" required autocomplete="name" value="{{$user->name}}">
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
                                <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" required autocomplete="email" value="{{$user->email}}">
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

                            <!-- Update Municipality Address -->
                            <div class="input-group mb-3">
                                <label for="muni_address" class="input-group">Municipality Address:</label>
                                <select id="muni_address" type="number" class="form-control @error('muni_address') is-invalid @enderror" name="muni_address" required autocomplete="muni_address" autofocus>
                                    <option value="{{$user->muni_address}}" selected>{{$user->municipality->name}}</option>
                                    <option value="1" >Badoc</option>
                                    <option value="2" >Banna</option>
                                    <option value="3" >Batac City</option>
                                    <option value="4" >Currimao</option>
                                    <option value="5" >Dingras</option>
                                    <option value="6" >Marcos</option>
                                    <option value="7" >Nueva Era</option>
                                    <option value="8" >Paoay</option>
                                    <option value="9" >Pinili</option>
                                    <option value="10" >San Nicolas</option>
                                    <option value="11" >Solsona</option>
                                </select>
                                @error('muni_address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror 
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                      <span class="fas fa-building"></span>
                                    </div>
                                </div>
                            </div>
                            <!-- /Update Municipality Address -->

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

                          <div class="modal-footer justify-content-between">
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
                        <div class="modal-header">
                          <h4 class="modal-title">Changing Password</h4>
                        </div>

                        <form method="POST" action="{{ route('userchangePassword',$user->id) }}">
                          @csrf
                          <div class="modal-body">


                            <!-- Update Password -->
                            <div class="input-group mb-3">
                                <input id="password" type="text" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="New Password">
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
                                <input id="password_confirmation" type="text" class="form-control @error('password') is-invalid @enderror" name="password_confirmation"  required autocomplete="new-password" placeholder="Retype New Password">
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
                            <button type="button" class="btn btn-default" data-dismiss="modal" data-toggle="modal" data-target="#update_{{$user->id}}">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                          </div>
                        </form>
                      </div>
                      </div>
                    </div>
                    <!-- /Change Password Modal -->
                  
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

