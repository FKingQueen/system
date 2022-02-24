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

  <!-- Theme style -->
  <link rel="stylesheet" href="https://adminlte.io/themes/v3/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
@endsection

@section('content')
@if(Auth::user())

  <!-- Content Header (Page header) -->
  <div class="content-header">
      <div class="container-fluid">
      <div class="row mb-2">
          <div class="col-sm-6">
              <h1 class="m-0">Registration Approval</h1>
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
              <table id="approval"  class="table table-bordered">
                <thead>
                <tr>
                  <th class="text-center" style="width: 55%;">Name</th>
                  <th class="text-center" style="width: 15%;">Role</th>
                  <th class="text-center" style="width: 15%;">ID Confirmation</th>
                  <th class="text-center" style="width: 0%;"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($approvals as $approval )
                  <tr>
                    <form method="POST" action="{{ route('approved',$approval->id) }}" >
                    @csrf
                    <td>{{$approval->name}}</td>
                    <td>
                      <select id="role_id" type="number" class="form-control @error('role_id') is-invalid @enderror" name="role_id" required autocomplete="role_id" autofocus>
                        <option disabled selected>Registrant Role</option>
                        <option value="1" >Admin</option>
                        <option value="2" >User</option>
                      </select>
                      @error('role_id')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </td>
                    <td class="text-center">
                      <button type="button" class="btn btn-close" data-toggle="modal" data-target="#modal-default_{{$approval->id}}">
                        view
                      </button>
                    </td>
                    <td>
                      <button type="submit" class="btn btn-success">
                        Approve
                      </button>
                    </td>
                    </form>
                  </tr>
               
                <!-- ID Confirmation Modal -->
                <div class="modal fade" id="modal-default_{{$approval->id}}">
                  <div class="modal-dialog">
                    <div class="modal-content">

                      <div class="modal-body">
                        <div class="d-flex justify-content-center">
                          <img src="{{ asset('uploads/approval/'.$approval->id_confirm)}}" width="70%" height="70%" alt="Image">
                        </div>
                      </div>

                      <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Done</button>
                      </div>

                    </div>
                  </div>
                </div>
                <!-- //ID Confirmation Modal -->

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

  $(function() {
    var Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });

    $('.swalDefaultSuccess').click(function() {
      Toast.fire({
        icon: 'success',
        title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
      })
    });

  });
</script>


<script>
  $(function () {
    $('#approval').DataTable({
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