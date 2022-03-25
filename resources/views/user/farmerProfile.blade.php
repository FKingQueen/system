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
@foreach($farmers as $farmer)

  <!-- Content Header (Page header) -->
  <div class="content-header">
      <div class="container-fluid">
      <div class="row mb-2">
          <div class="col-sm-6">
              <h1 class="m-0 farm_title">Farmer Profile</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('farmerList') }}">FarmerList</a></li>
              <li class="breadcrumb-item active">FarmerProfile</li>
            </ol>
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
            <div class="card-body">

              <table id="farmerList"  class="table table-bordered">
                <div class="d-flex">
                  <div class="ml-2">
                    
                    <h1 class="p-0 mb-1 m-0">
                    <u style="color: #248139;" >{{$farmer->name}}</u> 
                    </h1>
                  </div>
                  <div class="d-flex justify-content-start ml-5 mt-2">
                      <div>
                        In Progress - <i class='fa fa-circle' style='color:#00db0f'></i>
                      </div>
                      <div class="ml-5">
                        Complete - <i class='fas fa-circle' style='color:#76756f'></i>
                      </div>
                    </div>
                    <div class="ml-auto">
                        <button type="button" data-toggle="modal" data-target="#compose" class="btn btn-primary">
                        Create Farming
                        </button>
                    </div>
                  </div>
                </div>
                <thead >
                    <tr class="bg-light" >
                        <th ><i class="fas fa-seedling"> </i>Crop Name</th>
                        <th style="width: 20%;"><i class="fas fa-wind"></i> Cropping Season</th>
                        <th style="width: 15%;"><i class="fas fa-drafting-compass"></i> Lot Size</th>
                        <th style="width: 15%;"><i class="fas fa-hand-holding-usd"></i> Yield</th>
                        <th class="text-center" style="width: 10%;"><i class="fas fa-edit"></i></th>
                    </tr>
                </thead>
                <tbody>
                  @foreach($farming_datas as $farming_data)
                    <tr >
                        <th class="d-flex justify-content-between" style="color: #248139">
                          <a>{{$farming_data->crop->name}}</a>
                          @if($farming_data->status->id == 1)
                            <i class='mt-1 fa fa-circle' style='color:#00db0f'></i>
                          @endif
                          @if($farming_data->status->id == 2)
                            <i class='mt-1 fas fa-circle' style='color:#76756f'></i>
                          @endif
                        </th>
                        <td>
                          {{$farming_data->cropping_season->name}}
                        </td>
                        <td>
                          {{$farming_data->lot_size}} Hectare
                        </td>
                        <td>
                          @if(is_null($farming_data->yield))
                            In progress
                          @else
                            {{$farming_data->yield}}
                          @endif
                        </td>
                        <td class="text-center">
                          <button type="button" class="p-0 btn btn-block btn-primary btn-xm"   data-toggle="modal" data-target="#option_{{$farming_data->id}}">Option</button>
                          
                          <!-- Option Modal -->
                          <div class="modal fade rounded" id="option_{{$farming_data->id}}" tabindex="-1" role="dialog" aria-labelledby="classInfo" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-sm">
                            <div class="modal-content rounded">

                              <div class="modal-header p-1 d-flex justify-content-center">
                                <h4 class="modal-title ml-2 ">Option</h4>
                              </div>

                              <div class="modal-body rounded bg-white">
                                <table class="table table-bordered">
                                  <tbody>
                                    <form method="POST" action="{{ route('deleteCrop', $farming_data->id)}}">
                                    @csrf
                                      <tr>
                                        <th class="pl-1 p-0 text-left font-weight-light"> Upload new Activity Data from the device</th>
                                        <td class="p-1">
                                        <button type="button"  class="btn btn-block btn-default border" {{ $farming_data->status_id == 2 ? 'disabled' : '' }} data-toggle="modal" data-dismiss="modal" data-target="#uploadActivity_{{$farming_data->id}}"><i class="fas fa-lg fa-upload" style="color: #0275d8;"></i></button> 
                                        </td>
                                      </tr>
                                      <tr >
                                        <th class="pl-1 p-0 text-left font-weight-light"> Update the Crop information</th>
                                        <td class="p-1">
                                          <button type="button" class="btn btn-block btn-default border" data-toggle="modal" data-dismiss="modal" data-target="#updateCrop_{{$farming_data->id}}"><i class="fas fa-lg fa-edit " style="color: #42ba96;"></i></i></button>
                                        </td>
                                      </tr>
                                      <tr>
                                        <th class=" pl-1 p-0 text-left font-weight-light" >Delete permanently the Crop records</th>
                                        <td class="p-1">
                                          <button type="submit" class="btn btn-block btn-default border"><i class="fas fa-lg fa-trash" style="color: #d9534f;"></i></button>
                                        </td>
                                      </tr>
                                    </form>
                                  </tbody>
                                </table>
                              </div>

                            </div>
                            </div>
                          </div>
                          <!-- /Option Modal -->
                          
                      </td>
                    </tr>

                    <!-- Update Crop Modal -->
                    <div class="modal fade" id="updateCrop_{{$farming_data->id}}">
                      <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content">

                        <div class="modal-header bg-green p-2">
                          <h4 class="modal-title">Updating Farming Activity</h4>
                        </div>

                            <form method="POST" action="{{ route('updateCrop', $farming_data->id) }}"> 
                              @csrf
                              <div class="modal-body bg-white">

                                <div class="input-group mb-3">
                                  <label for="crop_name" class="input-group">Crop Name:</label>
                                  <select value="" id="crop_id" type="text" name="crop_id" class="custom-select form-control-border @error('crop_id') is-invalid @enderror" name="crop_id" required autocomplete="crop_id" autofocus>
                                      <option class="bg-primary" value="{{$farming_data->crop_id}}" selected>{{$farming_data->crop->name}}</option>
                                      <option value="1">Bitter Gourd (Ampalaya)</option>
                                      <option value="2">Cabbage</option>
                                      <option value="3">Corn</option>
                                      <option value="4">Eggplant</option>
                                      <option value="5">Garlic</option>
                                      <option value="6">Ladys Finger (Okra)</option>
                                      <option value="7">Rice</option>
                                      <option value="8">Onion</option>
                                      <option value="9">Peanut</option>
                                      <option value="10">String Beans (Sitaw)</option>
                                      <option value="11">Tobacco</option>
                                      <option value="12">Tomato</option>
                                      <option value="13">Water Melon</option>
                                  </select>
                                    @error('crop_id')
                                      <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                      </span>
                                    @enderror          
                                  <div class="input-group-append">
                                    <div class="input-group-text">
                                      <i class="fas fa-seedling"></i>
                                    </div>
                                  </div>
                                </div>

                                <div class="input-group mb-3">
                                  <label for="status_id" class="input-group">Data Classification:</label>
                                  <select id="updateStatus_id" type="text" name="status_id" class="custom-select form-control-border @error('status_id') is-invalid @enderror" name="status_id" required autocomplete="status_id" autofocus>
                                      <option value="" disabled selected>--- Select Classification ---</option>
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
                                      <i class="fas fa-info-circle"></i>
                                    </div>
                                  </div>
                                </div>

                                <div class="container-fluid p-3 border border-top-0 mb-3 rounded">

                                  <div class="input-group mb-1">
                                    <label for="updateField_unit" class="input-group">Field Size Unit:</label>
                                    <select id="updateField_unit" type="text" name="field_unit" class="custom-select form-control-border  @error('field_unit') is-invalid @enderror" name="field_unit" required autocomplete="field_unit" autofocus>
                                        <option value="" disabled selected>--- Select Field Size Unit ---</option>
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
                                        <i class="fas fa-arrows-alt-h"></i>
                                      </div>
                                    </div>
                                  </div>

                                  <div class="d-flex justify-content-center input-group">
                                    <div class="text-center w-25 input-group-sm">
                                      <label id="updateUnit_name" name="unit_name" class="font-weight-light">Hectare:</label>
                                      <input id="updateLot_size" type="text"  class="text-center form-control @error('lot_size') is-invalid @enderror" name="lot_size" required autocomplete="lot_size" autofocus placeholder="ha">
                                      @error('lot_size')
                                        <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                        </span>
                                      @enderror          
                                    </div>
                                  </div>

                                </div>

                                <div id="updateYield_id" class="input-group p-3 border border-top-0 mb-3 rounded">
                                  <label for="yield" class="input-group">Yield:</label>
                                  <div class="d-flex justify-content-center">
                                    <div>
                                      <br>
                                      <label class="mt-2 font-weight-light">Yield (t/ha): </label>
                                    </div>
                                    
                                    <div class="col-4 input-group-sm">
                                      <label for="kg" class="input-group  font-weight-light" >Number of sacks: </label>
                                      <input id="updateSacks" name="sacks" type="number" class="form-control" placeholder="sacks" min="0" autocomplete="kg" autofocus>
                                    </div>
                                      
                                    <div class="col-4 input-group-sm">
                                      <label for="kg" class="input-group font-weight-light">Weight of sack: </label>
                                      <input id="updateKg" name="kg" type="number" class="form-control" min="0" step=".001" placeholder="kg" autocomplete="kg" autofocus>
                                    </div>
                                  </div>
                                </div>

                              </div>

                              <div class="modal-footer justify-content-between bg-white">
                                  <button type="button" class="btn btn-close" data-dismiss="modal">Close</button>
                                  <button type="submit" class="btn btn-primary">Save changes</button>
                              </div>
                            </form>
                      </div>
                      </div>
                    </div>
                    <!-- /Udpate Crop Modal -->

                    <!-- Uplaod Activity Modal -->
                    <div class="modal fade" id="uploadActivity_{{$farming_data->id}}">
                      <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content">

                        <div class="modal-header bg-green p-2">
                          <h4 class="modal-title">Uploading Farming Activity</h4>
                        </div>

                            <form method="POST" action="{{ route('uploadActivity', $farming_data->id) }}" enctype="multipart/form-data"> 
                              @csrf
                              <div class="modal-body bg-white">

                                <div class="input-group mb-3">
                                  <label for="status_id" class="input-group">Data Classification:</label>
                                  <select id="updateStatus_id" type="text" name="status_id" class="custom-select form-control-border @error('status_id') is-invalid @enderror" name="status_id" required autocomplete="status_id" autofocus>
                                      <option value="" disabled selected>--- Select Classification ---</option>
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
                                      <i class="fas fa-seedling"></i>
                                    </div>
                                  </div>
                                </div>

                                <div id="updateYield_id" class="input-group p-3 border border-top-0 mb-3 rounded">
                                  <label for="yield" class="input-group">Yield:</label>
                                  <div class="d-flex justify-content-center">
                                    <div>
                                      <br>
                                      <label class="mt-2 font-weight-light">Yield (t/ha): </label>
                                    </div>
                                    
                                    <div class="col-4 input-group-sm">
                                      <label for="kg" class="input-group  font-weight-light" >Number of sacks: </label>
                                      <input id="updateSacks" name="sacks" type="number" class="form-control" placeholder="sacks" min="0" autocomplete="kg" autofocus>
                                    </div>
                                      
                                    <div class="col-5
                                    
                                    \input-group-sm">
                                      <label for="kg" class="input-group font-weight-light">Weight of sack: </label>
                                      <input id="updateKg" name="kg" type="number" class="form-control"  min="25" max="85" step=".001" placeholder="kg" autocomplete="kg" autofocus>
                                    </div>
                                  </div>
                                </div>

                                <div class="input-group">
                                <label for="activity_file">Insert Activity File (Required):</label>
                                <div class="input-group mb-3">  
                                    <input id="activity_file" type="file" class="form-control @error('activity_file') is-invalid @enderror" name="activity_file" required autocomplete="activity_file">
                                    @error('activity_file')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror 
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                    <i class="fas fa-file-alt"></i>
                                    </div>
                                </div>
                              </div>

                              </div>



                              <div class="modal-footer justify-content-between bg-white p-0">
                                  <button type="button" class="btn btn-close" data-dismiss="modal">Close</button>
                                  <button type="submit" class="btn btn-primary">Save changes</button>
                              </div>
                            </form>
                      </div>
                      </div>
                    </div>
                    <!-- /Upload Activity Modal -->

                  @endforeach
                </tbody>
              </table>

              <!-- Create Farming Modal -->
              <div class="modal fade" id="compose">
                <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                  <div class="modal-header bg-green p-2">
                    <h4 class="modal-title">Creating Farming Activity</h4>
                  </div>

                      <form method="POST" action="{{ route('compose', $farmer->id)}}" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body bg-white">

                          <div class="input-group mb-3">
                            <label for="crop_name" class="input-group">Crop Name:</label>
                            <select id="crop_id" type="text" name="crop_id" class="custom-select form-control-border @error('crop_id') is-invalid @enderror" name="crop_id" required autocomplete="crop_id" autofocus>
                              <option value="" disabled selected>--- Select  Crop ---</option>
                              <option value="1">Bitter Gourd (Ampalaya)</option>
                              <option value="2">Cabbage</option>
                              <option value="3">Corn</option>
                              <option value="4">Eggplant</option>
                              <option value="5">Garlic</option>
                              <option value="6">Ladys Finger (Okra)</option>
                              <option value="7">Rice</option>
                              <option value="8">Onion</option>
                              <option value="9">Peanut</option>
                              <option value="10">String Beans (Sitaw)</option>
                              <option value="11">Tobacco</option>
                              <option value="12">Tomato</option>
                              <option value="13">Water Melon</option>
                            </select>
                              @error('crop_id')
                                <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                                </span>
                              @enderror          
                            <div class="input-group-append">
                              <div class="input-group-text">
                                <i class="fas fa-seedling"></i>
                              </div>
                            </div>
                          </div>

                          <div class="input-group mb-3">
                            <label for="status_id" class="input-group">Data Classification:</label>
                            <select id="status_id" type="text" name="status_id" class="custom-select form-control-border @error('status_id') is-invalid @enderror" name="status_id" required autocomplete="status_id" autofocus>
                                <option value="" disabled selected>--- Select Classification ---</option>
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
                                <i class="fas fa-info-circle"></i>
                              </div>
                            </div>
                          </div>

                          <div class="container-fluid p-3 border border-top-0 mb-3 rounded">

                            <div class="input-group mb-1">
                              <label for="field_unit" class="input-group">Field Size Unit:</label>
                              <select id="field_unit" type="text" name="field_unit" class="custom-select form-control-border  @error('field_unit') is-invalid @enderror" name="field_unit" required autocomplete="field_unit" autofocus>
                                  <option value=""s disabled selected>--- Select Field Size Unit ---</option>
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
                                  <i class="fas fa-arrows-alt-h"></i>
                                </div>
                              </div>
                            </div>

                            <div class="d-flex justify-content-center input-group">
                              <div class="text-center w-25 input-group-sm">
                                <label id="unit_name" name="unit_name" class="font-weight-light">Hectare:</label>
                                <input id="lot_size" type="number"  class="text-center form-control @error('lot_size') is-invalid @enderror"  name="lot_size" required autocomplete="lot_size" autofocus placeholder="ha">
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
                              
                              <div class="col-5 input-group-sm">
                                <label for="kg" class="input-group  font-weight-light" >Number of sacks: </label>
                                <input id="sacks" name="sacks" type="number" class="form-control" placeholder="sacks" min="0" autocomplete="kg" autofocus>
                              </div>
                                
                              <div class="col-4 input-group-sm">
                                <label for="kg" class="input-group font-weight-light">Weight of sack: </label>
                                <input id="kg" name="kg" type="number" class="form-control" min="25" max="85"  placeholder="kg" autocomplete="kg" autofocus>
                              </div>
                            </div>
                          </div>

                          <div class="input-group">
                            <label for="activity_file">Insert Activity File (Required):</label>
                            <div class="input-group mb-3">  
                                <input id="activity_file" type="file" class="form-control @error('activity_file') is-invalid @enderror" name="activity_file" required autocomplete="activity_file">
                                @error('activity_file')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror 
                            <div class="input-group-append">
                                <div class="input-group-text">
                                  <i class="fas fa-file-alt"></i>
                                </div>
                            </div>
                          </div>

                        </div>

                        <div class="modal-footer justify-content-between bg-white p-0">
                            <button type="button" class="btn btn-close" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Compose</button>
                        </div>
                      </form>
                </div>
                </div>
              </div>
              <!-- /Create Farming Modal -->

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
    // Create Farming Activity Field Unit JS 
    $(function(){
      
      $('[id="unit_name"]').hide();
      $('[id="lot_size"]').hide();
      $('select[id="field_unit"]').on('change', function() {
        var field_unit = $(this).val();
        
          if(field_unit == 1){
            $('[id="unit_name"]').show();
            $('[id="lot_size"]').show();
            $('[id="unit_name"]').text("Hectare:");
            $('[id="lot_size"]').attr("placeholder", "ha");
            $('[id="lot_size"]').attr("max", "10");
            $('[id="lot_size"]').attr("min", ".1");
            $('[id="lot_size"]').attr("step", ".1");
          }

          else if(field_unit == 2){
            $('[id="unit_name"]').show();
            $('[id="lot_size"]').show();
            $('[id="unit_name"]').text("Square Meter:");
            $('[id="lot_size"]').attr("placeholder", "sq");
            $('[id="lot_size"]').attr("max", "100000");
            $('[id="lot_size"]').attr("min", "50");
            $('[id="lot_size"]').attr("step", ".1");
          }
      });
    });
    
    $(function(){

      $('#yield_id').hide(); 
      $('select[id="status_id"]').on('change', function() {
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

    // Update Farming Activity Field Unit JS 
    $(function(){
      $('[id="updateUnit_name"]').hide();
      $('[id="updateLot_size"]').hide();
      $('select[id="updateField_unit"]').on('change', function() {
        var field_unit = $(this).val();
          if(field_unit == 1){
            $('[id="updateUnit_name"]').show();
            $('[id="updateLot_size"]').show();
            $('[id="updateUnit_name"]').text("Hectare:");
            $('[id="updateLot_size"]').attr("placeholder", "ha");
            $('[id="updateLot_size"]').attr("max", "10");
            $('[id="updateLot_size"]').attr("min", ".1");
            $('[id="updateLot_size"]').attr("step", ".1");
          }
          else if(field_unit == 2){
            $('[id="updateUnit_name"]').show();
            $('[id="updateLot_size"]').show();
            $('[id="updateUnit_name"]').text("Square Meter:");
            $('[id="updateLot_size"]').attr("placeholder", "sq");
            $('[id=updateLot_size"]').attr("max", "100000");
            $('[id=updateLot_size"]').attr("min", "50");
            $('[id=updateLot_size"]').attr("step", ".1");
          }
      });
    });

    $(function(){
      $('[id="updateYield_id"]').hide(); 
      $('select[id="updateStatus_id"]').on('change', function() {
        var status_id = $(this).val();
          if(status_id == 1){
            $('[id="updateYield_id"]').hide(); 
            $('[id="updateSacks"]').removeAttr('required');
            $('[id="updateKg"]').removeAttr('required');
          }
          else if(status_id == 2){
            $('[id="updateYield_id"]').show(); 
            $('[id="updateSacks"]').attr('required', '');
            $('[id="updateKg"]').attr('required', '');
          }
      });
    });
  </script>
@endsection
