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
                      <input value="{{$currentyear}}"  type="radio" class="btn-check " name="btnradio" id="btnradio5" autocomplete="off" checked>
                      </div>
                    </form>
                  </div>
                
  
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

                <div class="d-flex justify-content-start">
              
                  <div>
                      <div class="input-group">

                        <h3 class="farmer_name">
                        {{$munis[0]->name}}

                          <small style="font-size: 20px;">({{$currentyear}})</small>
                        </h3>

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
                    @foreach($brgys as $key1 => $brgy)
                    <tr>
                      <td style="height: 90px;">
                        {{$brgy}}
                      </td>

                      @for($i = 0; $i <= 11; $i++)

                      <td class="p-0" >
                        <table class="container-fluid table-borderless">
                          <tbody class="container-fluid">
                            @foreach($data[$key1][$i] as $key2 => $datas)
                             <tr class="container-fluid">
                                @if($datas != 'empty' && $datas != 'null')
                                  <td style="cursor: pointer;color: #248139; background-color: #C1E1C1; font-size: 10px; " class="p-0 text-center">
                                      {{$datas}}
                                  </td>
                                @elseif($datas == 'null')
                                  <td class="p-0 text-center" style="background-color: #fff; color: #fff; font-size: 10px; ">
                                    {{$datas}}
                                  </td>
                                @endif
                             </tr>
                            @endforeach
                          </tbody>
                        </table>

                      </td>
                      @endfor
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
  <!-- /.content -->



@endsection

@section('js')
<script type='text/javascript'>

$(document).ready(function() { 
  $('input[name=btnradio]').change(function(){
        $('form[id=yearform]').submit();
  });
});

</script>

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
    if (year1 <= 2010 && year2 <= 2011 && year3 <= 2012 && year4 <= 2013 && year5 <= 2014) {
        
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
    if(year1 == currentyear)
    {
      return no_box1.innerHTML = year1,
          no_box2.innerHTML = year2,
          no_box3.innerHTML = year3,
          no_box4.innerHTML = year4,
          no_box5.innerHTML = year5,
          document.getElementById("btnradio1").checked = true;
    }
    if(year2 == currentyear)
    {
      return no_box1.innerHTML = year1,
          no_box2.innerHTML = year2,
          no_box3.innerHTML = year3,
          no_box4.innerHTML = year4,
          no_box5.innerHTML = year5,
          document.getElementById("btnradio2").checked = true;
    }
    if(year3 == currentyear)
    {
      return no_box1.innerHTML = year1,
          no_box2.innerHTML = year2,
          no_box3.innerHTML = year3,
          no_box4.innerHTML = year4,
          no_box5.innerHTML = year5,
          document.getElementById("btnradio3").checked = true;
    }

    if(year4 == currentyear)
    {
      return no_box1.innerHTML = year1,
          no_box2.innerHTML = year2,
          no_box3.innerHTML = year3,
          no_box4.innerHTML = year4,
          no_box5.innerHTML = year5,
          document.getElementById("btnradio4").checked = true;
    }
    if(year5 == currentyear)
    {
      
      return no_box1.innerHTML = year1,
          no_box2.innerHTML = year2,
          no_box3.innerHTML = year3,
          no_box4.innerHTML = year4,
          no_box5.innerHTML = year5,
          document.getElementById("btnradio5").checked = true;
    }
    return no_box1.innerHTML = year1,
          no_box2.innerHTML = year2,
          no_box3.innerHTML = year3,
          no_box4.innerHTML = year4,
          no_box5.innerHTML = year5,
          document.getElementById("btnradio1").checked = false,
          document.getElementById("btnradio2").checked = false,
          document.getElementById("btnradio3").checked = false,
          document.getElementById("btnradio4").checked = false,
          document.getElementById("btnradio5").checked = false;
}
</script>

@endsection