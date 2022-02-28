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
@foreach($farmers as $farmer)

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
            <div class="d-flex">
                <div class="ml-2">
                  <h1>
                    {{$farmer->name}}
                  </h1>
                </div>
                <div class="d-flex justify-content-start ml-5 mt-3 ">
                    <div>
                      In Progress - <i class='fa fa-circle' style='color:#00db0f'></i>
                    </div>
                    <div class="ml-5">
                      Complete - <i class='fas fa-circle' style='color:#76756f'></i>
                    </div>
                  </div>
                <div class="ml-auto">
                    <button type="button" data-toggle="modal" data-target="#compose" class="btn btn-primary">
                    Compose
                    </button>
                </div>
                </div>
                <thead >
                    <tr class="bg-light" >
                        <th ><i class="fas fa-seedling"> </i>Crop Name</th>
                        <th style="width: 15%;"><i class="fas fa-wind"></i> Cropping Season</th>
                        <th style="width: 10%;"><i class="fas fa-drafting-compass"></i> Lot Size</th>
                        <th style="width: 8%;"><i class="fas fa-hand-holding-usd"></i> Yield</th>
                        <th style="width: 0%;">Unit</th>
                        <th style="width: 0%;">Action</th>
                    </tr>
                </thead>
                <tbody>
                  @foreach($farming_datas as $farming_data)
                    <tr >
                        <td class="d-flex justify-content-between">
                          <a>{{$farming_data->crop->name}}</a>
                          @if($farming_data->status->id == 1)
                            <i class='mt-1 fa fa-circle' style='color:#00db0f'></i>
                          @endif
                          @if($farming_data->status->id == 2)
                            <i class='mt-1 fas fa-circle' style='color:#76756f'></i>
                          @endif
                        </td>
                        <td>
                          {{$farming_data->cropping_season->name}}
                        </td>
                        <td>
                          {{$farming_data->lot_size}} Hectare
                        </td>
                        <td>
                          {{$farming_data->yield}}
                        </td>
                        <td>
                          {{$farming_data->unit}}
                        </td>
                        <td>
                          Update
                        </td>
                    </tr>
                  @endforeach
                </tbody>
            </table>

            <!-- Compose Modal -->
            <div class="modal fade" id="compose">
                <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                  <div class="modal-header bg-green">
                    <h4 class="modal-title">Composing Farming Activity</h4>
                  </div>

                      <form method="POST" action="{{ route('compose', $farmer->id)}}">
                        @csrf
                        <div class="modal-body bg-white">

                          <div class="input-group mb-3">
                            <label for="crop_name" class="input-group">Crop Name:</label>
                            <select id="crop_id" type="text" name="crop_id" class="custom-select form-control-border @error('crop_id') is-invalid @enderror" name="crop_id" required autocomplete="crop_id" autofocus>
                                <option disabled selected>--- Select Plant ---</option>
                                <option value="1">Bitter Gourd (Ampalaya)</option>
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
                            <label for="status_id" class="input-group">Data Classification:</label>
                            <select id="status_id" type="text" name="status_id" class="custom-select form-control-border @error('status_id') is-invalid @enderror" name="status_id" required autocomplete="status_id" autofocus>
                                <option disabled selected>--- Select Classification ---</option>
                                <option value="1">Partial</option>
                                <option value="2">Complete</option>
                            </select>
                              @error('status_id')
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

                          <div class="container-fluid p-3 border border-top-0 mb-3 rounded">

                            <div class="input-group mb-1">
                              <label for="field_unit" class="input-group">Field Size Unit:</label>
                              <select id="field_unit" type="text" name="field_unit" class="custom-select form-control-border  @error('field_unit') is-invalid @enderror" name="field_unit" required autocomplete="field_unit" autofocus>
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

                            <div class="d-flex justify-content-center input-group">
                              <div class="text-center w-25 input-group-sm">
                                <label name="unit_name" class="font-weight-light">Hectare:</label>
                                <input id="lot_size" type="text"  class="text-center form-control @error('lot_size') is-invalid @enderror" name="lot_size" required autocomplete="lot_size" autofocus placeholder="ha">
                                @error('lot_size')
                                  <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                  </span>
                                @enderror          
                              </div>
                            </div>

                          </div>

                          <div id="yield_id" class="input-group p-3 border border-top-0 mb-3 rounded">
                            <label for="yield" class="input-group">Yield:</label>
                            <div class="d-flex justify-content-center">
                              <div>
                                <br>
                                <label class="mt-2 font-weight-light">Yield (t/ha): </label>
                              </div>
                              
                              <div class="col-4 input-group-sm">
                                <label for="kg" class="input-group  font-weight-light" >Number of sacks: </label>
                                <input id="sacks" name="sacks" type="number" class="form-control" placeholder="sacks" min="0" autocomplete="kg" autofocus>
                              </div>
                                
                              <div class="col-4 input-group-sm">
                                <label for="kg" class="input-group font-weight-light">Weight of sack: </label>
                                <input id="kg" name="kg" type="number" class="form-control" min="0" step=".001" placeholder="kg" autocomplete="kg" autofocus>
                              </div>
                            </div>
                          </div>



                        </div>

                        <div class="modal-footer justify-content-between bg-white">
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


@endforeach
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
      $('[name="unit_name"]').hide();
      $('[name="lot_size"]').hide();
      $('select[name="field_unit"]').on('change', function() {
        var field_unit = $(this).val();
          if(field_unit == 1){
            $('[name="unit_name"]').show();
            $('[name="lot_size"]').show();
            $('[name="unit_name"]').text("Hectare:");
            $('[name="lot_size"]').attr("placeholder", "ha");
          }
          else if(field_unit == 2){
            $('[name="unit_name"]').show();
            $('[name="lot_size"]').show();
            $('[name="unit_name"]').text("Square Meter:");
            $('[name="lot_size"]').attr("placeholder", "sq");
          }
      });
    });

    $(function(){
      $('#yield_id').hide(); 
      $('select[name="status_id"]').on('change', function() {
        var status_id = $(this).val();
          if(status_id == 1){
            $('#yield_id').hide(); 
            $("#sacks").removeAttr('required');
            $("#kg").removeAttr('required');
          }
          else if(status_id == 2){
            $('#yield_id').show(); 
            $("#sacks").attr('required', '');
            $("#kg").attr('required', '');
          }
      });
    });
  </script>
@endsection