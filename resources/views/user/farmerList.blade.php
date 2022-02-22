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


  <!-- Content Header (Page header) -->
  <div class="content-header">
      <div class="container-fluid">
      <div class="row mb-2">
          <div class="col-sm-6">
              <h1 class="m-0">Farmer List</h1>
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
              <table id="farmerList"  class="table table-bordered">
                <div class="d-flex justify-content-end mb-3">
                  <button type="button" data-toggle="modal" data-target="#addfarmer" class="btn btn-primary">
                    Add Farmer
                  </button>
                </div>
                <thead>
                <tr>
                  <th class="text-center">Name</th>
                  <th class="text-center">Date</th>
                  <th class="text-center">Action</th>
                </tr>
                </thead>
                <tbody>
                  <tr>
                    @csrf
                    <td>Sample</td>
                    <td>
                      Sample
                    </td>
                    <td>
                      Sample
                    </td>
                  </tr>
                </tbody>

              </table>

              <!-- Add Farmer Modal -->
              <div class="modal fade" id="addfarmer">
                <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                  <div class="modal-header">
                    <h4 class="modal-title">Adding Farmer</h4>
                  </div>

                  <form method="POST" action="">
                      @csrf

                      <div class="modal-body ">

                        <div class="input-group mb-3">
                          <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Full Name">
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

                        <div class="input-group mb-3">
                          <input id="municipality" type="text" class="form-control @error('municipality') is-invalid @enderror" name="municipality" value="{{ old('municipality') }}" required autocomplete="municipality" autofocus placeholder="Municipality">
                            @error('municipality')
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



                        <div class="input-group mb-3">
                          <input id="barangay" type="text" class="form-control @error('barangay') is-invalid @enderror" name="barangay" value="{{ old('barangay') }}" required autocomplete="barangay" autofocus placeholder="Barangay">
                            @error('barangay')
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

                      </div>

                      <div class="modal-footer justify-content-between ">
                          <button type="button" class="btn btn-close" data-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-primary">Add Farmer</button>
                      </div>
                  </form>
                </div>
              </div>
            <!-- /Add Farmer Modal -->  

            </div>
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
    $(function () {
      $('#farmerList').DataTable({
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