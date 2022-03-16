@extends('layouts.layout')

@section('css')

@endsection

@section('content')

  <!-- Content Header (Page header) -->
  <div class="content-header">
      <div class="container-fluid">
      <div class="row">
          <div class="col-sm-6">
              <h1 class="m-0">Yield Monitoring</h1>
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
              <table class="table">
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
                      <th scope="row">{{$key+1}}</th>
                      <td>{{$farmerName[$key]}}</td>
                      <td> 
                        <a type="button" data-toggle="modal" data-target="#activity_{{$data1->id}}">Inspect</a>
                      </td>
                      <td>{{$data1->yield}}</td>
                      <td>
                        <a class="btn btn-success" href="{{ route('generatePDF') }}">Report</a>
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
                              <div><h2>{{$data1->crop->name}}</h2></div>
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