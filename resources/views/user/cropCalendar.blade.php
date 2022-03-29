@extends('layouts.layout')

@section('css')
<style>
  /* Tooltip */
.tooltip > .tooltip-inner {
    background-color: #fff; 
    width: 100%;
    padding-bottom: 0%;
    color:  #248139; 
    border: solid 1px;
    border-color: #248139;
  }
  </style>
@endsection

@section('content')

  <!-- Content Header (Page header) -->
  <div class="content-header">
      <div class="container-fluid">
      <div class="row">
          <div class="col-sm-6">
              <h1 class="m-0 farm_title">Crop Calendar</h1>
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
            <div class="card-body p-0">
            <div class="pt-2 d-flex container-fluid justify-content-center">
              <h5>Year</h5>
            </div>
            <table >
                <thead>
                <tr >
                  <td class="p-0"><img src="{{ asset('images/greenline.png')}}" width="100%" alt="Image"></td>
                  <td class="p-0"><img src="{{ asset('images/greenline.png')}}" width="100%" alt="Image"></td>
                  <td class="p-0"><img src="{{ asset('images/greenline.png')}}" width="100%" alt="Image"></td>
                  <td class="p-0"><img src="{{ asset('images/greenline.png')}}" width="100%" alt="Image"></td>
                  <td class="p-0"><img src="{{ asset('images/greenline.png')}}" width="100%" alt="Image"></td>
                </tr>
                <tr>
                    @foreach($years as $year)
                        <td class="p-0 text-center font-weight-bold">{{$year}}</td>
                    @endforeach
                </tr>

              </thead>
              <tbody >
                <tr class="p-0">
                  <th>
                    <div class="p-0 container-fluid text-center">
                        @foreach($crops as $crop)
                            @foreach($percentages[4] as $percentage[0])
                                @if($percentage[0] != 0)
                                    @if($crop->id == $loop->iteration)
                                        <small class="p-0" style="color: #248139; ">{{$crop->name}} {{$percentage[0]}} %</small> <br>
                                    @endif
                                @endif
                            @endforeach
                        @endforeach
                    </div>
                  </th>
                  <th>
                    <div class="p-0 container-fluid text-center">
                        @foreach($crops as $crop)
                            @foreach($percentages[3] as $percentage[0])
                                @if($percentage[0] != 0)
                                    @if($crop->id == $loop->iteration)
                                        <small class="p-0" style="color: #248139; ">{{$crop->name}} {{$percentage[0]}} %</small> <br>
                                    @endif
                                @endif
                            @endforeach
                        @endforeach
                    </div>
                  </th>
                  <th>
                    <div class="p-0 container-fluid text-center">
                        @foreach($crops as $crop)
                            @foreach($percentages[2] as $percentage[0])
                                @if($percentage[0] != 0)
                                    @if($crop->id == $loop->iteration)
                                        <small class="p-0" style="color: #248139; ">{{$crop->name}} {{$percentage[0]}} %</small> <br>
                                    @endif
                                @endif
                            @endforeach
                        @endforeach
                    </div>
                  </th>
                  <th>
                    <div class="p-0 container-fluid text-center">
                        @foreach($crops as $crop)
                            @foreach($percentages[1] as $percentage[0])
                                @if($percentage[0] != 0)
                                    @if($crop->id == $loop->iteration)
                                        <small class="p-0" style="color: #248139; ">{{$crop->name}} {{$percentage[0]}} %</small> <br>
                                    @endif
                                @endif
                            @endforeach
                        @endforeach
                    </div>
                  </th>
                  <th>
                    <div class="p-0 container-fluid text-center">
                    @foreach($crops as $crop)
                        @foreach($percentages[0] as $percentage[0])
                            @if($percentage[0] != 0)
                                @if($crop->id == $loop->iteration)
                                    <small class="p-0 m-0" style="color: #248139; ">{{$crop->name}} {{$percentage[0]}} %</small> <br>
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

                <div class="d-flex justify-content-center">
              
                  <div>
                      <div class="input-group">
                        @foreach($munis as $muni)
                        <h1>
                        <u style="color: #248139;" >{{$muni->name}}</u> 

                          <small style="font-size: 20px;">({{$currentyear}})</small>
                        </h1>
                        @endforeach
                      </div>
                  </div>
                
                </div>


              <table class="table table-bordered">
                <thead>
                  <tr class="text-center ">
                    <th scope="col" style="width: 0%;">Barangay</th>
                    <th scope="col" style="width: 8%;">Jan</th>
                    <th scope="col" style="width: 8%;">Feb</th>
                    <th scope="col" style="width: 8%;">Mar</th>
                    <th scope="col" style="width: 8%;">Apr</th>
                    <th scope="col" style="width: 8%;">May</th>
                    <th scope="col" style="width: 8%;">Jun</th>
                    <th scope="col" style="width: 8%;">Jul</th>
                    <th scope="col" style="width: 8%;">Aug</th>
                    <th scope="col" style="width: 8%;">Sep</th>
                    <th scope="col" style="width: 8%;">Oct</th>
                    <th scope="col" style="width: 8%;">Nov</th>
                    <th scope="col" style="width: 8%;">Dec</th>
                  </tr>
                </thead>
                <tbody>
                    @php $i=0 @endphp
                    @php $mc=11 @endphp
                    @foreach($brgys as $brgy)
                      <tr>
                        <td>{{$brgy->name}}</td>
                        
                        @while($i <=$mc)
                          <td class="p-0 text-center" style ="{{ $percs[$i] == null ? 'background-color: green;' : ''}} font-size: 10px;">
                            <table class=" container-fluid">
                              <tbody> 

                                @foreach($percs[$i] as $perc[0])

                                @php $try=$loop->iteration @endphp
                                    @if($perc[0] != 0)
                                      @php $check=1 @endphp
                                      @foreach($crops as $crop)
                                        @if($try == $loop->iteration)
                                              <tr class="p-0">
                                                <td class="p-0 font-weight-bold" style="color: #248139; background-color: #C1E1C1;">

                                                  <a type="button" id="try_{{$loop->iteration}}" > {{$crop->name}}</a>

                                                  <script>
                                                    $(document).ready(function(){
                                                      $('#try_{{$loop->iteration}}').tooltip({title: "<h5>{{$crop->name}} <br> {{$perc[0]}}%</h5>",html: true, placement: "top", animation: true,}); 
                                                    });
                                                  </script>
                                                  
                                                </td>
                                              </tr>
                                        @endif
                                      @endforeach
                                    @endif
                                @endforeach
                              </tbody>
                            </table>
                          </td>
                        @php $i++ @endphp
                        @endwhile
                      </tr>
                      @php $i = ($loop->iteration)*12 @endphp
                      @php $mc = $mc+12 @endphp
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
  <!-- /.content -->



@endsection

@section('js')


@endsection