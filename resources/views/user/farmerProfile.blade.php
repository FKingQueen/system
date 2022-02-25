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
              <h1 class="m-0">Farmer Profile</h1>
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
            <div class="d-flex justify-content-between mb-5">
                <div class="ml-5">
                    @foreach($farmers as $farmer)
                        {{$farmer->name}}
                    @endforeach
                </div>
                <div>
                    <button type="button" data-toggle="modal" data-target="#compose" class="btn btn-primary">
                    Compose
                    </button>
                </div>
                </div>
                <thead >
                    <tr class="bg-light" >
                        <th >Crop Name</th>
                        <th >Cropping Season</th>
                        <th >Status</th>
                        <th >Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr >
                        <td>

                        </td>
                        <td>

                        </td>
                        <td>

                        </td>
                        <td>

                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- Compose Modal -->
            <div class="modal fade" id="compose">
                <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                  <div class="modal-header">
                    <h4 class="modal-title">Composing Farming Activity</h4>
                  </div>

                      <form method="POST" action="">
                        @csrf
                        <div class="modal-body ">

                          <div class="input-group mb-3">
                            <label for="crop_name" class="input-group">Crop Name:</label>
                            <select id="crop_id" type="text" name="crop_id" class="form-control @error('crop_id') is-invalid @enderror" name="crop_id" required autocomplete="crop_id" autofocus>
                                <option disabled selected>--- Select Plant ---</option>
                                <option value="1">Bitter Gourd (Ampalya)</option>
                                <option value="2">Corn</option>
                                <option value="3">Ladys Finger (Okra)</option>
                                <option value="4">Rice</option>
                                <option value="5">String Beans (Sitaw)</option>
                            </select>
                              @error('crop_id')
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
                            <label for="crop_name" class="input-group">Cropping Season:</label>
                            <select id="crop_id" type="text" name="crop_id" class="form-control @error('crop_id') is-invalid @enderror" name="crop_id" required autocomplete="crop_id" autofocus>
                                <option disabled selected>--- Select Cropping Season ---</option>
                                <option value="1">Dry Season</option>
                                <option value="2">Wet Season</option>
                            </select>
                              @error('crop_id')
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
                            <label for="field_unit" class="input-group">Field Size Unit:</label>
                            <select id="field_unit" type="text" name="field_unit" class="form-control @error('field_unit') is-invalid @enderror" name="field_unit" required autocomplete="field_unit" autofocus>
                                <option disabled selected>--- Select Field Size Unit ---</option>
                                <option value="1">Hectare</option>
                                <option value="2">Square Meter</option>
                            </select>
                              @error('field_unit')
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

                          <div class="d-flex justify-content-center input-group mb-3">
                            <div class="text-center w-25">
                              <label name="unit_name">Hectare:</label>
                              <input id="lot_size" type="text" class="text-center form-control @error('lot_size') is-invalid @enderror" name="lot_size" required autocomplete="lot_size" autofocus placeholder="ha">
                              @error('lot_size')
                                <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                                </span>
                              @enderror          
                            </div>
                          </div>

                          <div class="input-group mb-3">
                            <label for="yield" class="input-group">Yield:</label>
                            <input id="yield" type="text" class="form-control @error('yield') is-invalid @enderror" name="yield" required autocomplete="yield" autofocus placeholder="Yield">
                              @error('yield')
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
                            <label for="unit" class="input-group">unit:</label>
                            <input id="unit" type="text" class="form-control @error('unit') is-invalid @enderror" name="unit" required autocomplete="unit" autofocus placeholder="unit">
                              @error('unit')
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
            <!-- /Compose Modal -->

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

    $(function(){
      $('select[name="field_unit"]').on('change', function() {
        var field_unit = $(this).val();
          if(field_unit == 1){
            $('[name="unit_name"]').text("Hectare:");
            $('[name="lot_size"]').attr("placeholder", "ha");
          }
          else if(field_unit == 2){
            $('[name="unit_name"]').text("Square Meter:");
            $('[name="lot_size"]').attr("placeholder", "sq");
          }
          
          
      });

    });
  </script>
@endsection