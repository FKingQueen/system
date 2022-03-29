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
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">

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
                  <th class="text-center" style="width: 30%;"><i class="fas fa-city"></i> Address</th>
                  <th class="text-center" style="width: 10%;"><i class="fas fa-edit"></i></th>
                </tr>
                </thead>
                <tbody>
                  @php $chk = 0 @endphp
                  @foreach ($farmers as $farmer)
                  <tr >
                    <td class="">
                      <div class='d-flex justify-content-between'>
                        <a type="button" class="farmer_link p-0" href="{{ route('farmerProfile', $farmer->id)}}">{{$farmer->name}}</a>
                        
                        @if($farmer->status == 1)
                          <i class='mt-2 fa fa-circle' style='color:#00db0f'></i>
                        @elseif($farmer->status == 2)
                          <i class='mt-2 fas fa-circle' style='color:#76756f'></i>
                        @endif

                      </div>
                    </td>
                    <td class="text-center " >
                      Brgy. {{$farmer->barangays->name}}, {{$farmer->municipality->name}}
                    </td>
                    <td class="text-center">
                      <button type="button" class="p-0 btn btn-block btn-primary btn-xm "   data-toggle="modal" data-target="#option_{{$farmer->id}}">Option</button>
                      <!-- Option Modal -->
                      <div class="modal fade rounded" id="option_{{$farmer->id}}">
                        <div class="modal-dialog modal-dialog-centered modal-sm">
                        <div class="modal-content rounded ">

                          <div class="modal-header p-1 d-flex justify-content-center">
                            <h4 class="modal-title">Option</h4>
                          </div>

                          <div class="modal-body rounded bg-white">
                            <form method="POST" action="{{ route('deleteFarmer', $farmer->id)}}">
                              @csrf
                              <table class="table table-bordered">
                                <tbody >
                                  <tr >
                                    <th class=" p-1 text-left font-weight-light"> Update the Farmer information</th>
                                    <td class="p-1">
                                      <button type="button" class="btn btn-block btn-default border" data-dismiss="modal" data-toggle="modal" data-target="#update_{{$farmer->id}}"><i class="fas fa-lg fa-edit " style="color: #42ba96;"></i></i></button>
                                    </td>
                                  </tr>
                                  <tr>
                                    <th class=" pl-1 p-0 text-left font-weight-light" >Delete permanently the Farmer records</th>
                                    <td class="p-1">
                                      <button type="button" data-dismiss="modal" data-target="#delete_{{$farmer->id}}" data-toggle="modal" class="btn btn-block btn-default border"><i class="fas fa-lg fa-trash" style="color: #d9534f;"></i></button>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                            </form>
                          </div>
                        </div>
                        </div>
                      </div>
                      <!-- /Option Modal -->  
                    </td>
                  </tr>

                  

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
                  <form method="POST" action="{{ route('deleteFarmer', $farmer->id)}}">
                  @csrf
                  <div id="delete_{{$farmer->id}}" class="modal fade">
                    <div class="modal-dialog modal-confirm modal-dialog-centered">
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
                    </div>
                  </div>
                  </form>
                  <!-- /Delete Confirmation Modal --> 
                  
                  @endforeach
                </tbody>

              </table>

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
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
    });
  </script>

@endsection