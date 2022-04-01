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
            <div class=" d-flex container-fluid justify-content-center">
              <h5 class="mr-3">Year</h5>
            </div>
            <table >
                <thead>
                <tr >
                <form id="yearform" action="{{ route('yearform') }}" method="post">
                  @csrf
                  <div class="btn-group input-group" role="group" aria-label="Basic radio toggle button group">
                    <input value="4" style="margin-left: 6%;" type="radio" class="btn-check " name="btnradio" id="btnradio1" autocomplete="off" {{$currentyear == 2018 ? 'checked': ''}}>
                    
                    
                    <input value="3" style="margin-left: 20%;" type="radio" class="btn-check cursor-pointer" name="btnradio" id="btnradio2" autocomplete="off" {{$currentyear == 2019 ? 'checked': ''}}>
                    

                    <input value="2" style="margin-left: 20%;" type="radio" class="btn-check" name="btnradio" id="btnradio3" autocomplete="off" {{$currentyear == 2020 ? 'checked': ''}}>
                    

                    <input value="1" style="margin-left: 20%;" type="radio" class="btn-check" name="btnradio" id="btnradio4" autocomplete="off" {{$currentyear == 2021 ? 'checked': ''}}>


                    <input value="0" style="margin-left: 20%;" type="radio" class="btn-check" name="btnradio" id="btnradio5" autocomplete="off" {{$currentyear == 2022 ? 'checked': ''}} >
                    
                  </div>
                </form>
                

                <script type='text/javascript'>

                $(document).ready(function() { 
                  $('input[name=btnradio]').change(function(){
                        $('form[id=yearform]').submit();
                  });
                  });

                </script>
                <div class="btn-group input-group" role="group" aria-label="Basic radio toggle button group">
                  <label style="margin-left: 5%;" > 2018</label>
                  <label style="margin-left: 18%;"> 2019</label>
                  <label style="margin-left: 18%;"> 2020</label>
                  <label style="margin-left: 18%;"> 2021</label>
                  <label style="margin-left: 18%;"> 2022</label>
                  
                </div>
                </tr>
                <!-- <tr>
                    @foreach($years as $year)
                        <td class="p-0 text-center font-weight-bold">{{$year}}</td>
                    @endforeach
                </tr> -->
              </thead>
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