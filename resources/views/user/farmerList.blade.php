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

  <!-- Ajax -->
  <script src="http://demo.itsolutionstuff.com/plugin/jquery.js"></script>

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
                <div class="d-flex justify-content-between mb-3">
                  <div class="d-flex justify-content-start">
                    <div>
                      In Progress - <i class='fa fa-circle' style='color:#00db0f'></i>
                    </div>
                    <div class="ml-5">
                      Inactive - <i class='fas fa-circle' style='color:#76756f'></i>
                    </div>
                  </div>
                  <div>
                  <button type="button" data-toggle="modal" data-target="#addfarmer" class="btn btn-primary">
                    Add Farmer
                  </button>
                  </div>
                </div>
                <thead >
                <tr class="bg-light" >
                  <th ><i class="fas fa-male"></i> Farmers Name:</th>
                  <th class="text-center" style="width: 20%;"><i class="fas fa-city"></i> Address</th>
                  <th class="text-center" style="width: 10%;"><i class="fas fa-edit"></i> Action</th>
                </tr>
                </thead>
                <tbody>
                  @foreach ($farmers as $farmer)
                  <tr >
                    <td class="">
                      <div class="d-flex justify-content-between">
                        <div>
                        <a href="{{ route('farmerProfile', $farmer->id)}}">{{$farmer->name}}</a>
                        </div>
                        <div>
                        <i class='fa fa-circle' style='color:#00db0f'></i>
                        </div>
                      </div>
                    </td>
                    <td class="text-center " >
                      Brgy. {{$farmer->barangay}}, {{$farmer->municipality}}
                    </td>
                    <td class="text-center">
                      Update
                    </td>
                  </tr>
                  @endforeach
                </tbody>

              </table>

              <!-- Add Farmer Modal -->
              <div class="modal fade" id="addfarmer">
                <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                  <div class="modal-header">
                    <h4 class="modal-title">Adding Farmer</h4>
                  </div>

                      <form method="POST" action="{{ route('addFarmer')}}">
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
                            <label for="crop_name" class="input-group">Municipality:</label>
                            <select id="municipality" type="text" name="municipality" class="form-control @error('municipality') is-invalid @enderror" name="municipality" required autocomplete="municipality" autofocus>
                                <option value="" disabled selected>--- Select Municipality ---</option>
                                @foreach ($municipalities as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
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
                            <label for="crop_name" class="input-group">Barangay:</label>
                            <select id="barangay" type="text" name="barangay" class="form-control @error('barangay') is-invalid @enderror" name="barangay" required autocomplete="barangay" autofocus>
                              <option value="" disabled selected>--- Select Barangay ---</option>
                            </select>
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

@endsection