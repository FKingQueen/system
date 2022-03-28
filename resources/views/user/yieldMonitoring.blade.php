@extends('layouts.layout')

@section('css')

@endsection

@section('content')

  <!-- Content Header (Page header) -->
  <div class="content-header">
      <div class="container-fluid">
      <div class="row">
          <div class="col-sm-6">
              <h1 class="m-0 farm_title">Yield Monitoring</h1>
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
              <form action="{{ route('yieldMonitoring') }}" method="GET">
                @csrf
                <div class="rounded bg-white p-0">
                    <div class="d-flex justify-content-left input-group mb-3 ">
                        <div>
                            <label for="crop_name" class="input-group">Municipality</label>
                            <select id="municipality" type="text" name="municipality" class=" form-control @error('municipality') is-invalid @enderror form-control-sm" name="municipality" required autocomplete="municipality" autofocus>
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
                        </div>

                        <div class="ml-3">
                            <label for="crop_name" class="input-group">Barangay</label>
                            <select id="barangay" type="text" name="barangay" class="form-control @error('barangay') is-invalid @enderror form-control-sm" name="barangay" required autocomplete="barangay" autofocus>
                                <option value="" disabled selected>--- Select Barangay ---</option>
                            </select>
                            @error('barangay')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>   
                        <div class="ml-3">
                            <label for="year_id" class="input-group">Year</label>
                            <select id="year_id" type="text" name="year_id" class="@error('year_id') is-invalid @enderror form-control form-control-sm" name="year_id" required autocomplete="year_id" autofocus>
                                    <option disabled selected>--- Select  Year ---</option>
                                @php 
                                    $year = now()->year-4;
                                @endphp

                                @for($i = 0; $i <= 4; $i++)
                                    <option value="{{$year}}">{{$year}}</option>
                                    @php $year = $year+1 @endphp
                                @endfor
                            </select>
                                @error('year_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror          
                        </div>     
                        <div class="ml-3">
                            <label for="crop_name" class="input-group">Crop</label>
                            <select id="crop_id" type="text" name="crop_id" class="form-control form-control-sm @error('crop_id') is-invalid @enderror" name="crop_id" required autocomplete="crop_id" autofocus>
                              <option disabled selected>--- Select  Crop ---</option>
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
                        </div>

                        <div class="ml-3">
                            <label for="cropping_season" class="input-group">Cropping Season</label>
                            <select id="cropping_season" type="text" name="cropping_season" class="form-control form-control-sm @error('cropping_season') is-invalid @enderror" name="cropping_season" required autocomplete="cropping_season" autofocus>
                              <option disabled selected>--- Select  Cropping Season ---</option>
                              <option value="1">Dry Season</option>
                              <option value="2">Wet Season</option>
                            </select>
                                @error('cropping_season')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror          
                        </div>
                        <div class="ml-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-sm  btn-block btn-primary input-group"> Search </button>
                        </div>
                    </div>                        
                </div>
              </form>
              <table class="table mt-4">
                <thead>
                  <tr class="text-center">
                    <th scope="col"></th>
                    <th scope="col">Farmer</th>
                    <th scope="col">Activities</th>
                    <th scope="col">Yield</th>
                    <th scope="col" >Generate</th>
                  </tr>
                </thead>
                <tbody class="text-center">
                  @foreach($data1s as $key => $data1)
                    <tr>
                      <th scope="row">{{$key+1}}.</th>
                      <td > <h5 class="mt-1"><b>{{$farmerName[$key]}}</b></h5> </td>
                      <td> 
                        <a type="button"  class="p-1 btn btn-close btn-xm " data-toggle="modal" data-target="#activity_{{$data1->id}}">Inspect</a>
                      </td>
                      <td ><h6 class="mt-2">{{$data1->yield}}</h6></td>
                      <td>
                        <a type="button" class="p-1 btn btn-primary btn-xm " href="{{ route('generatePDF', $data1->id) }}">Report</a>
                      </td>
                      <td>
                        <!-- Farming Activity Modal -->
                        <div class="modal fade rounded" id="activity_{{$data1->id}}" tabindex="-1" role="dialog" aria-labelledby="classInfo" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered modal-lg">
                          <div class="modal-content rounded">

                            <div class="modal-header p-1 d-flex justify-content-around">
                              <h4 class="modal-title ml-2 ">Farming Activities</h4>
                            </div>

                            <div class="modal-body">
                              <div><h2 style="color: #248139">{{$data1->crop->name}}</h2></div>
                              <table class="table table-bordered">
                                <tbody>
                                  @for($i= 0; $i <= 2; $i++)
                                    <tr>
                                      <th class="w-50">                                    
                                        @if($i == 0)
                                          Water
                                        @elseif($i == 1)
                                          Fertilizer
                                        @elseif($i == 2)
                                          Pesticide
                                        @endif
                                      </th>
                                      <td  class="w-50">
                                        {{$activity[$key][$i]}}%({{$activityC[$key][$i]}})
                                      </td>
                                    </tr>
                                  @endfor
                                </tbody>
                              </table>

                              <div class="d-flex justify-content-center">
                                <table class="w-50">
                                  <tbody>
                                    <tr>
                                      <th class="w-50">Cropping Season</th>
                                      <td  class="w-50">{{$data1->cropping_season->name}}</td>
                                    </tr>
                                    <tr>
                                      <th class="w-50">Duration</th>
                                      <td  class="w-50">{{$days[$key]}} Days</td>
                                    </tr>
                                    <tr>
                                      <th class="w-50">Start-End</th>
                                      <td  class="w-50">{{$fmonth[$key]}}-{{$lmonth[$key]}}</td>
                                    </tr>
                                  </tbody>
                                </table>
                              </div>

                            </div>

                          </div>
                          </div>
                        </div>
                        <!-- /Farming Activity Modal -->

                      </td>
                    </tr>


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

@endsection