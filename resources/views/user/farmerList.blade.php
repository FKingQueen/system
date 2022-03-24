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

@endsection

@section('content')
  <!-- Content Header (Page header) -->
  <div class="content-header">
      <div class="container-fluid">
      <div class="row mb-2">
          <div class="col-sm-6">
              <h1 class="m-0 farm_title">Farmer List</h1>
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
                      Brgy. {{$farmer->barangays->name}}, {{$farmer->municipality}}
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
                                      <button type="submit" class="btn btn-block btn-default border"><i class="fas fa-lg fa-trash" style="color: #d9534f;"></i></button>
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

                              <div class="input-group mb-3">
                                <label for="crop_name" class="input-group">Municipality:</label>
                                <select id="municipality" type="text" name="municipality" class="form-control @error('municipality') is-invalid @enderror" name="municipality" value="{{$farmer->municipality}}" required autocomplete="municipality" autofocus>
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
                                <select id="barangay" type="text" name="barangay" class="form-control @error('barangay') is-invalid @enderror" name="barangay" value="{{$farmer->municipality}}" required autocomplete="barangay" autofocus>
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

                            <div class="modal-footer justify-content-between bg-white p-1">
                                <button type="button" class="btn btn-close" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                          </form>
                    </div>
                    </div>
                  </div>
                  <!-- /Update Farmer Modal --> 
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
                                <i class="fas fa-city"></i>
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
                                <i class="fas fa-home"></i>
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