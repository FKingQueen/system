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

    /* floating Button */
    .float{
    position:fixed;
    width:130px;
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
    /* floating Button */
  </style>
@endsection

@section('content')
  <!-- Content Header (Page header) -->
  <div class="content-header">
      <div class="container-fluid">
      <div class="row mb-2">
          <div class="col-sm-6">
              <h1 class="m-0 farm_title">Farmer History</h1>
          </div>
          <!-- /.col -->
      </div><!-- /.row -->
      </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <a data-toggle="dropdown" type="button" class="float">
    <i style='color:#ffffff' class="fas fa-file-export fa-lg my-float"></i>
    <span style='color:#ffffff'>Add Farmer</span>
  </a>

      <div id="sample" class="dropdown-menu dropdown-menu-lg dropdown-menu-left ">
      
        <div class="dropdown-divider"></div>
          <a data-dismiss="modal" data-toggle="modal" data-target="#addfarmer" class="btn btn-default d-flex justify-content-start" >
            Add new farmer
          </a>

        <div class="dropdown-divider"></div>
          <a data-dismiss="modal" data-toggle="modal" data-target="#import"  class="btn btn-default d-flex border-bottom justify-content-start">
            Import
          </a>
      </div>


  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
              <table id="farmerList"  class="table table-bordered">
                <thead >
                <tr class="bg-light" >
                  <th ><i class="fas fa-male" style="color:#b0b0b0"></i> Farmers Name:</th>
                  <th class="text-center" style="width: 30%;"><i class="fas fa-city" style="color:#b0b0b0"></i> Address</th>
                  <th class="text-center" style="width: 10%;"><i class="fas fa-edit" style="color:#b0b0b0"></i></th>
                </tr>
                </thead>
                <tbody>
                  @php $chk = 0 @endphp
                  @foreach ($farmers as $key => $farmer)
                  <tr >
                    <td class="">
                      <div class='d-flex justify-content-between'>
                        <a type="button" class="farmer_link p-0" href="{{ route('farmerProfile', $farmer->id)}}">{{$farmer->name}}</a>
                        @if($far[$key][0] != 0)
                          <div class="rounded w-20 bg-success p-1">{{$far[$key][0]}}</div>
                        @elseif($far[$key][0] == 0)
                          <div class="rounded w-20 bg-secondary p-1">{{$far[$key][0]}}</div>
                        @endif
                      
                      </div>
                    </td>
                    <td class="text-center " >
                      Brgy. {{$farmer->barangays->name}}, {{$farmer->municipality->name}}
                    </td>
                    <td class="text-center">
                      <a class="p-0 btn btn-block btn-primary btn-xm" data-toggle="dropdown" href="#">
                        Option
                      </a>
                      <div id="sample" class="dropdown-menu dropdown-menu-lg dropdown-menu-right ">
                      
                        <div class="dropdown-divider"></div>
                          <a data-dismiss="modal" data-toggle="modal" data-target="#update_{{$farmer->id}}" class="btn btn-default d-flex justify-content-around" >
                            Edit
                            <i class="fas fa-lg fa-edit ml-2" style="color: #42ba96;"></i>
                          </a>

                        <div class="dropdown-divider"></div>
                          <a data-dismiss="modal" data-toggle="modal" data-target="#delete_{{$farmer->id}}"  class="btn btn-default d-flex border-bottom justify-content-around">
                            Delete
                            <i class="fas fa-lg fa-trash mr-2" style="color: #d9534f;"></i>
                          </a>
                      </div>

                      <!-- Update Modal -->
                      <div class="modal fade" id="update_{{$farmer->id}}">
                        <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content  bg-green">

                          <div class="modal-header p-2">
                            <h4 class="modal-title">Updating Farmer</h4>
                          </div>

                              <form method="POST" action="{{ route('updateFarmer', $farmer->id)}}">
                                @csrf
                                <div class="modal-body bg-white">

                                  <!-- UpdateFarmer Input Name -->
                                  <div class="input-group mb-3">
                                    <label for="crop_name" class="input-group">Name:</label>
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{$farmer->name}}" required autocomplete="name" autofocus placeholder="Full Name">
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
                                  <!-- ./UpdateFarmer Input Name -->

                                  <!-- UpdateFarmer Select Barangay -->
                                  <div class="input-group mb-3">
                                    <label for="UpdateFarmer_Barangay" class="input-group">Barangay:</label>
                                    <select id="barangay" type="text" name="barangay" class="form-control @error('barangay') is-invalid @enderror" name="barangay" required autocomplete="barangay" autofocus>
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
                                    <div class="input-group-append">
                                      <div class="input-group-text">
                                        <i class="fas fa-home"></i>
                                      </div>
                                    </div>
                                  </div>
                                  <!-- /UpdateFarmer Select Barangay -->

                                </div>

                                <div class="modal-footer justify-content-between bg-white p-1">
                                    <button type="button" class="btn btn-close" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                              </form>
                        </div>
                        </div>
                      </div>
                      <!-- /Update Farmer Modal --> 

                      <!-- Delete Confirmation Modal -->
                     
                      <div id="delete_{{$farmer->id}}" class="modal fade">
                        <div class="modal-dialog modal-confirm modal-dialog-centered">
                          <form method="POST" action="{{ route('deleteFarmer', $farmer->id)}}">
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
                    </td>
                  </tr>

                  


                  
                  @endforeach
                </tbody>

              </table>

              <!-- Import Farmer Modal -->
              <div class="modal fade" id="import">
                <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content  bg-green">

                  <div class="modal-header p-2">
                    <h4 class="modal-title">Importing</h4>
                  </div>

                      <form method="POST" action="{{ route('importfarmer')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body bg-white">

                          <div class="input-group">
                            <label for="importfarmer">Insert Farmer File (Required):</label>
                            <div class="input-group mb-3">  
                                <input id="importfarmer" type="file" class="form-control @error('importfarmer') is-invalid @enderror" name="importfarmer" required autocomplete="importfarmer">
                                @error('importfarmer')
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

                        </div>

                        <div class="modal-footer justify-content-between bg-white p-1">
                            <button type="button" class="btn btn-close" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add Farmer</button>
                        </div>
                      </form>
                </div>
                </div>
              </div>
              <!-- /Import Farmer Modal -->  

              <!-- Add Farmer Modal -->
              <div class="modal fade" id="addfarmer">
                <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content  bg-green">

                  <div class="modal-header p-2">
                    <h4 class="modal-title">Adding Farmer</h4>
                  </div>

                      <form method="POST" action="{{ route('addFarmer')}}">
                        @csrf
                        <div class="modal-body bg-white">

                          <!-- AddFarmer Input Name -->
                          <div class="input-group mb-3">
                            <label for="crop_name" class="input-group">Name:</label>
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
                          <!-- /AddFarmer Input Name -->

                          <!-- AddFarmer Select Barangay -->
                          <div class="input-group mb-3">
                            <label for="AddFarmer_Barangay" class="input-group">Barangay:</label>
                            <select id="barangay" type="text" name="barangay" class="form-control @error('barangay') is-invalid @enderror" name="barangay" required autocomplete="barangay" autofocus>
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
                            <div class="input-group-append">
                              <div class="input-group-text">
                                <i class="fas fa-home"></i>
                              </div>
                            </div>
                          </div>
                          <!-- /AddFarmer Select Barangay -->

                        </div>

                        <div class="modal-footer justify-content-between bg-white p-1">
                            <button type="button" class="btn btn-close" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add Farmer</button>
                        </div>
                      </form>
                </div>
                </div>
              </div>
              <!-- /Add Farmer Modal -->

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
        "ordering": false,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
    });
  </script>

  @error('name') 
    <script>
      $(function() {
          $('#addfarmer').modal('show');
      });
    </script>
  @enderror

@endsection