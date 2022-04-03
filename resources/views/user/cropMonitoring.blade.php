@extends('layouts.layout')

@section('css')
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
@endsection

@section('content')

  <!-- Content Header (Page header) -->
  <div class="content-header">
      <div class="container-fluid">
      <div class="row">
          <div class="col-sm-6">
              <h1 class="m-0 farm_title">Crop Monitoring</h1>
          </div>
          <!-- /.col -->
      </div><!-- /.row -->
      </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->


  <div class="card-body">
                
    <form action="{{ route('cropMonitoring') }}" method="GET">
      @csrf
      <div class="modal-body rounded bg-white">
        <div class="d-flex justify-content-between">
          <div class="d-flex justify-content-left mb-3">
              <div>
                  <label for="UpdateFarmer_Barangay" class="input-group">Barangay:</label>
                  <select id="barangay" type="text" name="barangay" class="form-control form-control-sm @error('barangay') is-invalid @enderror" name="barangay" required autocomplete="barangay" autofocus>
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
              </div>
              <div class="ml-3">
                  <label for="year_id" class="input-group">Year</label>
                  <select id="year_id" type="text" name="year_id" class="form-control form-control-sm @error('year_id') is-invalid @enderror" name="year_id" required autocomplete="year_id" autofocus>
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
              <div class="ml-3 d-flex align-items-end">
                  <button type="submit" class="btn btn-sm btn-block btn-primary input-group"> Search </button>
              </div>

          </div>

        </div>
      </div>
    </form>

  </div>
  <!-- /.card-body -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <!-- /.card-header -->
              <div class="card-body">

                <div class="input-group  d-flex justify-content-center">
                  <h3 class="text-center ">FARMING ACTIVITY</h3>
                </div>

                <div class="input-group" >
                  <table class="table table-bordered text-center">
                    <thead>

                      <tr> 
                        <th scope="col" style="width: 25%;" >
                        Farmer
                        </th>

                        <th style="width: 100%;" >
                          <div class=" d-flex justify-content-center">
                            <div class="ml-5">
                              Water 
                            </div>
                            <div style="width: 5%;" class="mr-5 bg-primary"></div>

                            <div >
                              Fertilizer 
                            </div>
                            <div style="width: 5%;" class="mr-5 bg-success"></div>

                            <div class="d-flex">
                              Pesticide 
                            </div>
                            <div style="width: 5%;" class="mr-5 bg-secondary"></div>
                          </div>
                        </th>
                      </tr>

                    </thead>
                    <tbody>

                      @php $j = 0 @endphp
                      @foreach($FA_counts as $key1 => $FA_count)
                        @if($FA_counts[$key1] != 0)
                          <tr>
                            <th style="cursor:pointer" data-toggle="modal" data-target="#activity_{{$key1}}">{{$Farmers[$key1]->name}}</th>
                            <td>
                              <div class="input-group w-100 d-flex justify-content-center">
                                <div class="bg-primary rounded-left" style="width: {{$FA_percents[$key1][0]}}%; opacity: 0.8;">{{$FA_percents[$key1][0]}}% ({{$FA_counts[$key1][0]}})</div>
                                <div class="bg-success " style="width: {{$FA_percents[$key1][1]}}%; opacity: 0.8;">{{$FA_percents[$key1][1]}}% ({{$FA_counts[$key1][1]}})</div>
                                <div class="bg-secondary rounded-right" style="width: {{$FA_percents[$key1][2]}}%; opacity: 0.8;">{{$FA_percents[$key1][2]}}% ({{$FA_counts[$key1][2]}})</div>
                              </div>

                              <!-- Farming Activities Modal -->
                              <div class="modal fade rounded" id="activity_{{$key1}}" tabindex="-1" role="dialog" aria-labelledby="classInfo" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content rounded">

                                  <div class="modal-header p-1 d-flex justify-content-center">
                                    <h4 class="modal-title ml-2 "><u style="color: #248139;" >{{$Farmers[$key1]->name}}</u> </h4>
                                  </div>

                                  <div class="modal-body rounded p-1 ">

                                    <table class="table ">
                                      <thead >
                                        <tr >
                                          <th style="width: 20%;" class="p-1">Crop</th>
                                          <th style="width: 10%;" class="p-1">Hectare</th>
                                          <th  class=" d-flex justify-content-around">
                                            <div class="ml-5">
                                              Water - 
                                            </div>
                                            <div style="width: 5%;" class="mr-5 bg-primary"></div>

                                            <div>
                                              Fertilizer - 
                                            </div>
                                            <div style="width: 5%;" class="mr-5 bg-success"></div>
  
                                            <div class="d-flex">
                                              Pesticide -   
                                            </div>
                                            <div style="width: 5%;" class="mr-5 bg-secondary"></div>
                                            
                                          </th>
                                        </tr>
                                      </thead>
                                      <tbody>

                                      @for($i = 0; $i <= $FD_counters[$key1]-1; $i++)
                                        
                                        <tr >
                                          <th class="">
                                              {{$FD_crops[$key1][$i][0]->crop->name}}
                                          </th >
                                          <td class="p-1"></td>
                                          <td class="w-100 ">
                                            <div class="d-flex justify-content-center">
                                              <div class="bg-primary rounded-left" style="width: {{$FD_percents[$key1][$i][0]}}%; opacity: 0.8;">{{$FD_percents[$key1][$i][0]}}% ({{$FD_counts[$key1][$i][0]}})</div>
                                              <div class="bg-success " style="width: {{$FD_percents[$key1][$i][1]}}%; opacity: 0.8;">{{$FD_percents[$key1][$i][1]}}% ({{$FD_counts[$key1][$i][1]}})</div>
                                              <div class="bg-secondary rounded-right" style="width: {{$FD_percents[$key1][$i][2]}}%; opacity: 0.8;">{{$FD_percents[$key1][$i][2]}}% ({{$FD_counts[$key1][$i][2]}})</div>
                                            </div>
                                          </td>
                                        </tr>
                                      @php $j++ @endphp
                                      @endfor         
                                      </tbody>
                                    </table>

                                </div>
                                </div>
                              </div>
                              <!-- /Farming Activities Modal -->

                            </td>
                          </tr>
                          @php $i++ @endphp
                        @endif
                      @endforeach
                      
                    </tbody>
                  </table>
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




@endsection

@section('js')

@endsection