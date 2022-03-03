@extends('layouts.layout')

@section('css')

@endsection

@section('content')

  <!-- Content Header (Page header) -->
  <div class="content-header">
      <div class="container-fluid">
      <div class="row">
          <div class="col-sm-6">
              <h1 class="m-0">Crop Calendar</h1>
          </div>
          <!-- /.col -->
      </div><!-- /.row -->
      </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <div class="p-0 d-flex container-fluid justify-content-center">
    <h5>Year</h5>
  </div>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <!-- /.card-header -->
            <div class="card-body">

            <table class=" p-0" >
                <thead>
                <tr>
                  <td class="p-0"><img src="{{ asset('images/greenline.png')}}" width="100%" alt="Image"></td>
                  <td class="p-0"><img src="{{ asset('images/greenline.png')}}" width="100%" alt="Image"></td>
                  <td class="p-0"><img src="{{ asset('images/greenline.png')}}" width="100%" alt="Image"></td>
                  <td class="p-0"><img src="{{ asset('images/greenline.png')}}" width="100%" alt="Image"></td>
                  <td class="p-0"><img src="{{ asset('images/greenline.png')}}" width="100%" alt="Image"></td>
                </tr>
                <tr>
                    @foreach($years as $year)
                        <td class="p-0 text-center">{{$year}}</td>
                    @endforeach
                </tr>

              </thead>
              <tbody class="p-0">
                <tr class="p-0">
                  <th class="p-0">
                    <div class="p-0 container-fluid text-center">
                        @foreach($crops as $crop)
                            @foreach($percentages[4] as $percentage[0])
                                @if($percentage[0] != 0)
                                    @if($crop->id == $loop->iteration)
                                        <small class="p-0">{{$crop->name}} {{$percentage[0]}} %</small> <br>
                                    @endif
                                @endif
                            @endforeach
                        @endforeach
                    </div>
                  </th>
                  <th class="p-0">
                    <div class="p-0 container-fluid text-center">
                        @foreach($crops as $crop)
                            @foreach($percentages[3] as $percentage[0])
                                @if($percentage[0] != 0)
                                    @if($crop->id == $loop->iteration)
                                        <small class="p-0">{{$crop->name}} {{$percentage[0]}} %</small> <br>
                                    @endif
                                @endif
                            @endforeach
                        @endforeach
                    </div>
                  </th>
                  <th class="p-0">
                    <div class="p-0 container-fluid text-center">
                        @foreach($crops as $crop)
                            @foreach($percentages[2] as $percentage[0])
                                @if($percentage[0] != 0)
                                    @if($crop->id == $loop->iteration)
                                        <small class="p-0">{{$crop->name}} {{$percentage[0]}} %</small> <br>
                                    @endif
                                @endif
                            @endforeach
                        @endforeach
                    </div>
                  </th>
                  <th class="p-0">
                    <div class="p-0 container-fluid text-center">
                        @foreach($crops as $crop)
                            @foreach($percentages[1] as $percentage[0])
                                @if($percentage[0] != 0)
                                    @if($crop->id == $loop->iteration)
                                        <small class="p-0">{{$crop->name}} {{$percentage[0]}} %</small> <br>
                                    @endif
                                @endif
                            @endforeach
                        @endforeach
                    </div>
                  </th>
                  <th class="p-0">
                    <div class="p-0 container-fluid text-center">
                    @foreach($crops as $crop)
                        @foreach($percentages[0] as $percentage[0])
                            @if($percentage[0] != 0)
                                @if($crop->id == $loop->iteration)
                                    <small class="p-0 m-0">{{$crop->name}} {{$percentage[0]}} %</small> <br>
                                @endif
                            @endif
                        @endforeach
                     @endforeach
                    </div>
                  </th>
                </tr>
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

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <!-- /.card-header -->
            <div class="card-body">

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