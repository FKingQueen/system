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


  <div class="container">

  
       
  
        
    </div>
  
   


  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <!-- /.card-header -->
            <div class="card-body p-0">
            <div class=" d-flex container-fluid justify-content-center">
              <h5 >Year</h5>
            </div>
            <table >
                <thead>
                <tr >
                
                  <div style="width: 97%;" class="container-fluid d-flex justify-content-center" role="group" aria-label="Basic radio toggle button group">
                    <form id="yearform" action="{{ route('yearform') }}" method="post">
                    @csrf
                      <div style="border-width:3px !important;" class=" p-1 w-25  d-flex justify-content-center border-bottom border-success">
                        <input value="{{$currentyear-4}}" type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off" >
                      </div>

                      <div style="border-width:3px !important;" class="w-25  d-flex justify-content-center border-bottom border-success">
                        <input value="{{$currentyear-3}}"  type="radio" class="btn-check " name="btnradio" id="btnradio2" autocomplete="off" >
                      </div>

                      <div style="border-width:3px !important;" class="n w-25  d-flex justify-content-center border-bottom border-success">
                        <input value="{{$currentyear-2}}" type="radio" class="btn-check " name="btnradio" id="btnradio3" autocomplete="off">
                      </div>

                      <div style="border-width:3px !important;" class="w-25  d-flex justify-content-center border-bottom border-success">
                      <input value="{{$currentyear-1}}"  type="radio" class="btn-check " name="btnradio" id="btnradio4" autocomplete="off" >
                      </div>

                      <div style="border-width:3px !important;" class="w-25  d-flex justify-content-center border-bottom border-success">
                      <input value="{{$currentyear}}"  type="radio" class="btn-check " name="btnradio" id="btnradio5" autocomplete="off" {{$currentyear == ? 'checked': ''}}>
                      </div>
                    </form>
                  </div>
                
                

                <script type='text/javascript'>

                $(document).ready(function() { 
                  $('input[name=btnradio]').change(function(){
                        $('form[id=yearform]').submit();
                  });
                  });

                </script>
                  <div class="w-100 container-fluid d-flex justify-content-center" role="group" aria-label="Basic radio toggle button group">
                    <div class="p-0">
                      <button class="btn p-0" onclick="prev()">
                        <i class="fas fa-lg fa-angle-double-left" style="color:#b0b0b0"></i>
                      </button>
                    </div>
                    <div class="w-25 p-1 d-flex justify-content-center no-box1">
                      <span class="year1" >{{$currentyear-4}}</span>
                    </div>

                    <div class="w-25  d-flex justify-content-center no-box2">
                      <span class="year2" >{{$currentyear-3}}</span>
                    </div>

                    <div class="w-25  d-flex justify-content-center no-box3">
                      <span class="year3" >{{$currentyear-2}}</span>
                    </div>

                    <div class="w-25  d-flex justify-content-center no-box4">
                      <span class="year4" >{{$currentyear-1}}</span>
                    </div>

                    <div class="w-25  d-flex justify-content-center no-box5">
                      <span class="year5" >{{$currentyear}}</span>
                    </div>
                    <div class="p-0">
                      <button class="btn p-0" onclick="next()">
                        <i class="fas fa-lg fa-angle-double-right" style="color:#b0b0b0"></i>
                      </button>
                    </div>
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

   <script>
        
        var currentyear = @json($currentyear);
        console.log(currentyear);
        var actualyear = <?php echo date("Y"); ?>;
        var no_box1 = document.querySelector('.no-box1');
        var no_box2 = document.querySelector('.no-box2');
        var no_box3 = document.querySelector('.no-box3');
        var no_box4 = document.querySelector('.no-box4');
        var no_box5 = document.querySelector('.no-box5');
              
        var year1 = currentyear-4;
        var year2 = currentyear-3;
        var year3 = currentyear-2;
        var year4 = currentyear-1;
        var year5 = currentyear;

        function prev() {
  
            // Start position 
            if (year1 == 2010 && year2 == 2011 && year3 == 2012 && year4 == 2013 && year5 == 2014) {
                
                // Add disabled attribute on
                // prev button
                document.getElementsByClassName('prev').disabled = true;
                // Remove disabled attribute 
                // from next button 
                document.getElementsByClassName('next').disabled = false;
            } else {
                year1--;
                document.getElementById("btnradio1").value = year1;
                year2--;
                document.getElementById("btnradio2").value = year2;
                year3--;
                document.getElementById("btnradio3").value = year3;
                year4--;
                document.getElementById("btnradio4").value = year4;
                year5--;
                document.getElementById("btnradio5").value = year5;
                
                return setNo();
            }
        }
  
        function next() {
  
            // End position
            if (year1 == actualyear-4 && year2 == actualyear-3 && year3 == actualyear-2  && year4 == actualyear-1 && year5 == actualyear) {
  
                // Add disabled attribute on 
                // next button
                document.getElementsByClassName('next').disabled = true;
  
                // Remove disabled attribute
                // from prev button
                document.getElementsByClassName('prev').disabled = false;
            } else {
                year1++;
                document.getElementById("btnradio1").value = year1;
                year2++;
                document.getElementById("btnradio2").value = year2;
                year3++;
                document.getElementById("btnradio3").value = year3;
                year4++;
                document.getElementById("btnradio4").value = year4;
                year5++;
                document.getElementById("btnradio5").value = year5;
                return setNo();
            }
        }
  
        function setNo() {
  
            // Change innerhtml
            return no_box1.innerHTML = year1,
                  no_box2.innerHTML = year2,
                  no_box3.innerHTML = year3,
                  no_box4.innerHTML = year4,
                  no_box5.innerHTML = year5;
        }
    </script>

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
                        <td style="height: 75px;">{{$brgy->name}}</td>
                        
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

                                                  <a type="button" class="p-0" id="try_{{$perc[0]}}{{$loop->iteration}}" > {{$crop->name}}</a>

                                                  <script>
                                                    $(document).ready(function(){
                                                      $('#try_{{$perc[0]}}{{$loop->iteration}}').tooltip({title: "<h5>{{$crop->name}} <br> {{$perc[0]}}%</h5>",html: true, placement: "top", animation: true,}); 
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