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
    .modal-confirm {		
      color: #636363;
      width: 400px;
    }
    .modal-confirm .modal-content {
      padding: 20px;
      padding-bottom: 0px;
      border-radius: 5px;
      border: none;
      text-align: center;
      font-size: 14px;
    }
    .modal-confirm .modal-header {
      border-bottom: none;   
      position: relative;
    }
    .modal-confirm h4 {
      text-align: center;
      font-size: 26px;
      margin: 30px 0 -10px;
    }
    .modal-confirm .close {
      position: absolute;
      top: -5px;
      right: -2px;
    }
    .modal-confirm .modal-body {
      color: #999;
    }
    .modal-confirm .modal-footer {
      border: none;
      text-align: center;		
      border-radius: 5px;
      font-size: 13px;
      padding: 5px 5x 15px;
    }
    .modal-confirm .modal-footer a {
      color: #999;
    }		
    .modal-confirm .icon-box {
      width: 80px;
      height: 80px;
      margin: 0 auto;
      border-radius: 50%;
      z-index: 9;
      text-align: center;
      border: 3px solid #f15e5e;
    }
    .modal-confirm .icon-box i {
      color: #f15e5e;
      font-size: 46px;
      display: inline-block;
      margin-top: 13px;
    }
    .modal-confirm .btn, .modal-confirm .btn:active {
      color: #fff;
      border-radius: 4px;
      background: #60c7c1;
      text-decoration: none;
      transition: all 0.4s;
      line-height: normal;
      min-width: 120px;
      border: none;
      min-height: 40px;
      border-radius: 3px;
      margin: 0 5px;
    }
    .modal-confirm .btn-secondary {
      background: #c1c1c1;
    }
    .modal-confirm .btn-secondary:hover, .modal-confirm .btn-secondary:focus {
      background: #a8a8a8;
    }
    .modal-confirm .btn-danger {
      background: #f15e5e;
    }
    .modal-confirm .btn-danger:hover, .modal-confirm .btn-danger:focus {
      background: #ee3535;
    }
    .trigger-btn {
      display: inline-block;
      margin: 100px auto;
    }

    
  </style>
@endsection

@section('content')
@foreach($farmers as $farmer)


  <!-- Content Header (Page header) -->
  <div class="content-header">
      <div class="container-fluid">
      <div class="row mb-2">
          <div class="col-sm-6">
              <h1 class="m-0 farm_title">Farmer Profile</h1>
              <button data-toggle="modal" data-target="#delete"  class="btn btn-block btn-default border d-flex justify-content-around">
                <b>Delete</b> 
              </button>

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
                    
                    <h1 class="p-0 mb-1 mb-3 m-0">
                    <u style="color: #248139;" >{{$farmer->name}}</u> 
                    </h1>
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
                        <th ><i class="fas fa-seedling" style="color: #248139"> </i>Crop Name</th>
                        <th style="width: 20%;"><i class="fas fa-wind" style="color: #248139"></i> Cropping Season</th>
                        <th style="width: 15%;"><i class="fas fa-drafting-compass" style="color: #248139"></i> Lot Size</th>
                        <th style="width: 15%;"><i class="fas fa-hand-holding-usd" style="color: #248139"></i> Yield</th>
                        <th style="width: 10%;"><i class="fas fa-solid fa-code" style="color: #248139"></i> Status</th>
                        <th class="text-center" style="width: 10%;"><i class="fas fa-edit" style="color: #248139"></i></th>
                    </tr>
                </thead>
                <tbody>
                  @foreach($farming_datas as $farming_data)
                    <tr>
                        <th style="color: #248139">
                          <a>{{$farming_data->crop->name}}</a>

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
                        <td class="text-center pt-2">
                          <input type="checkbox" class="toggle-class_{{$farming_data->id}}" data-id="{{$farming_data->id}}" data-size="sm" data-width="90"   data-onstyle="success" data-offstyle="secondary" data-toggle="toggle" data-on="Inprogress" data-off="Completed" {{ $farming_data->status ? 'checked' : '' }}>

                          <script>
                            $(function() {
                              $('.toggle-class_{{$farming_data->id}}').change(function() {
                                  var status = $(this).prop('checked') == true ? 1 : 0; 
                                  var yield = ('');
                                  console.log(status);
                                  var id = $(this).data('id'); 
                                  
                                  $.ajax({
                                      type: 'GET',
                                      url: '/changeStatus',
                                      dataType: 'json',
                                      data: {'status': status, 'id': id},
                                      //success: function(data){console.log(data.success)}
                                  });

                                  if(status == 0)
                                  {
                                    $("#yield{{$farming_data->id}}").modal("show");
                                    $("#updatedisabled_{{$farming_data->id}}").attr("class", "btn btn-block btn-default border d-flex justify-content-around disabled");
                                  }

                              });
                            });
                          </script>
                          
                        </td>
                          
                        <td class="text-center">
                          
                            <a class="p-0 btn btn-block btn-primary btn-xm" data-toggle="dropdown" href="#">
                              Option
                            </a>
                            <div id="sample" class="dropdown-menu dropdown-menu-xl dropdown-menu-right ">
                              
                              <div class="dropdown-divider"></div>
                                <a id="updatedisabled_{{$farming_data->id}}" data-dismiss="modal"  data-toggle="modal" data-target="#uploadActivity_{{$farming_data->id}}" class="btn btn-block btn-default border d-flex justify-content-around">
                                  <b>Upload</b> 
                                  <i class="fas fa-lg fa-upload" style="color: #0275d8;"></i>
                                </a>
          
                              <div class="dropdown-divider"></div>
                                <a data-dismiss="modal" data-toggle="modal" data-target="#updateCrop_{{$farming_data->id}}" class="btn btn-block btn-default border d-flex justify-content-around" >
                                  <b class="ml-1">Edit</b> 
                                  <i class="fas fa-lg fa-edit ml-4" style="color: #42ba96;"></i>
                                </a>

                              <div class="dropdown-divider"></div>
                                <a data-dismiss="modal" data-toggle="modal" data-target="#delete_{{$farming_data->id}}"  class="btn btn-block btn-default border d-flex justify-content-around">
                                  <b>Delete</b> 
                                  <i class="fas fa-lg fa-trash" style="color: #d9534f;"></i>
                                </a>
                            </div>


                            <!-- Delete Confirmation Modal -->
                            <div id="delete_{{$farming_data->id}}" class="modal fade">
                              <div class="modal-dialog modal-confirm modal-dialog-centered">
                                <form method="POST" action="{{ route('deleteCrop', $farming_data->id) }}">
                                @csrf
                                <div class="modal-content">
                                  <div class="modal-header flex-column">
                                    <div class="icon-box">
                                    <i class="material-icons">&#xE5CD;</i>
                                    
                                    </div>						
                                    <h4 class="modal-title w-100 ">Are you sure?</h4>	
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body p-0">
                                    <p>Do you really want to delete these records? This process cannot be undone.</p>
                                  </div>
                                  <div class="modal-footer justify-content-center">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                  </div>
                                </div>
                                </form>
                              </div>
                            </div>
                          <!-- /Delete Confirmation Modal --> 

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


                          <!-- Yield Farming Modal -->
                          <div class="modal fade" id="yield{{$farming_data->id}}">
                            <div class="modal-dialog modal-dialog-centered">
                              <div class="modal-content">

                                  <div class="modal-header bg-green p-2">
                                  <h4 class="modal-title">Update Yield</h4>
                                  </div>

                                      <form method="POST" action="{{ route('updateYield', $farming_data->id)}}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-body bg-white">

                                            <div class="d-flex justify-content-center">
                                                <div>
                                                <br>
                                                <label class="mt-2 font-weight-light">Yield (t/ha): </label>
                                                </div>
                                                
                                                <div class="col-5 input-group-sm">
                                                <label for="kg" class="input-group  font-weight-light" >Number of sacks: </label>
                                                <input id="sacks" name="sacks" type="number" class="form-control" placeholder="sacks" min="0" autocomplete="kg" autofocus value="{{$farming_data->sacks}}">
                                                </div>
                                                
                                                <div class="col-4 input-group-sm">
                                                <label for="kg" class="input-group font-weight-light">Weight of sack: </label>
                                                <input id="kg" name="kg" type="number" class="form-control" min="25" max="85"  placeholder="kg" autocomplete="kg" autofocus value="{{$farming_data->kg}}">
                                                </div>
                                            </div>

                                        </div>

                                        <div class="modal-footer justify-content-around bg-white p-0">
                                            <button  type="button" class="btn btn-close" data-dismiss="modal">Don't Update</button>
                                            <button  type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                      </form>
                              </div>
                            </div>
                        </div>
                        <!-- /Yield Farming Modal -->

                        <!-- Upload Activity Modal -->
                        <div class="modal fade" id="uploadActivity_{{$farming_data->id}}">
                          <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">

                              <div class="modal-header bg-green p-2">
                                <h4 class="modal-title">Uploading Farming Activity</h4>
                              </div>

                                  <form method="POST" action="{{ route('uploadActivity', $farming_data->id) }}" enctype="multipart/form-data"> 
                                    @csrf
                                    <div class="modal-body bg-white">

                                      <div id="updateYield_id" class="input-group p-3 border border-top-0 mb-3 rounded">
                                        <label for="yield" class="input-group">Yield:</label>
                                        <div class="d-flex justify-content-center">
                                          <div>
                                            <br>
                                            <label class="mt-2 font-weight-light">Yield (t/ha): </label>
                                          </div>
                                          
                                          <div class="col-5 input-group-sm">
                                            <label for="kg" class="input-group  font-weight-light" >Number of sacks: </label>
                                            <input id="updateSacks" name="sacks" type="number" class="form-control" placeholder="sacks" min="0" autocomplete="kg" autofocus>
                                          </div>
                                            
                                          <div class="col-4 input-group-sm">
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

                        </td>
                    </tr>

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

                          <div class="p-0 input-group mb-3">

                            <div class="w-50">
                              <label for="field_unit">Field Size Unit:</label>
                              <select id="field_unit" type="text" name="field_unit" class="custom-select form-control-border  @error('field_unit') is-invalid @enderror" name="field_unit" required autocomplete="field_unit" autofocus>
                                  <option value="1">Hectare</option>
                                  <option value="2">Square Meter</option>
                              </select>
                              
                                @error('field_unit')
                                  <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                  </span>
                                @enderror    
                            </div>

                            <div class="text-center w-50 col-auto" >
                                <label id="unit_name" name="unit_name" class="font-weight-light"></label>
                                <input id="lot_size" type="number"  class="text-center form-control @error('lot_size') is-invalid @enderror mt-2"  name="lot_size" required autocomplete="lot_size" autofocus placeholder="ha">
                                @error('lot_size')
                                  <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                  </span>
                                @enderror          
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

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" ></script>
  <script src="{{ asset('js/app.js') }}"></script>
  <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
  
  

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
      

      $('select[id="field_unit"]').on('change', function() {
        var field_unit = $(this).val();
        
          if(field_unit == 1){
            $('[id="unit_name"]').show();
            $('[id="lot_size"]').show();
            $('[id="lot_size"]').attr("placeholder", "ha");
            $('[id="lot_size"]').attr("max", "10");
            $('[id="lot_size"]').attr("min", ".1");
            $('[id="lot_size"]').attr("step", ".1");
          }

          else if(field_unit == 2){
            $('[id="unit_name"]').show();
            $('[id="lot_size"]').show();
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
