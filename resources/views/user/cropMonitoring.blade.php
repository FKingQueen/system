@extends('layouts.layout')

@section('css')
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<style>
  .float{
	position:fixed;
	width:80px;
	height:40px;
	bottom:20px;
	right:40px;
  background-color: #28a745;
  color: #FFF;
	border-radius:50px;
	text-align: center;
	box-shadow: 2px 4px 4px #999;
  z-index: 1;
}

.float:hover {
  background-color: #51d870;
}

.my-float{
	margin-top:13px;
}
.tooltip-inner::before {
  background-color: #fff;
  box-shadow: -2px -2px 2px 0 rgba( 178, 178, 178, .4);
  display: block;
  width: 8px;
  height: 8px;
  margin: auto;
  position: absolute;
  left: 0;
  right: 0;
  top: -1px;
  transform: rotate( 45deg);
  -moz-transform: rotate( 45deg);
  -ms-transform: rotate( 45deg);
  -o-transform: rotate( 45deg);
  -webkit-transform: rotate( 45deg);
  margin-top: 2px;
}

.tooltip-inner {
  background-color: #fff !important;
  color: #000 !important;
  box-shadow: 0px 0px 6px #B2B2B2;
  border: solid 1pt;
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
              <h1 class="m-0 farm_title">Crop Monitoring</h1>
          </div>
          <!-- /.col -->
      </div><!-- /.row -->
      </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->
  <!-- HTML to write -->

  <a id="download" type="button" onclick= "downloadPDF()" class="float">
    <i style='color:#ffffff' class="fas fa-file-export fa-lg my-float"></i>
  </a>

  <script>
    $(document).ready(function(){
      $('#download').tooltip({title: "Export to pdf",html: true, placement: "top", animation: true,}); 
    });
  </script>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <!-- /.card-header -->
            <div class="card-body p-0">
              <form action="{{ route('cropMonitoringsearch') }}" method="GET">
                @csrf
                <div class="modal-body rounded bg-white">
                  <div class="d-flex justify-content-between">
                    <div class="d-flex justify-content-left">
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
                            <label for="year_id" class="input-group">Year:</label>
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
                            <button type="submit" class="btn btn-sm btn-block btn-primary input-group"> Filter </button>
                        </div>

                    </div>

                  </div>
                </div>
              </form>
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

  </section>
    <!-- Main content -->
    <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <!-- /.card-header -->
            <div class="card-body mt-2 p-1 d-flex justify-content-center">
              <h1 class="p-0 farmer_name">
                {{$muni}} 
                <i style="font-size: 14pt;">{{$jsyear}}</i>
              </h1>
              
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

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <!-- /.card-header -->
              <div class="card-body">
                <h5 class="text-center mt-3">The Total Number of Crops Sown in Barangay {{$brgy}}</h5>
                <canvas id="myChart" width="400" height="200"></canvas>
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
  <!-- Main /.content -->

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
                        <th scope="col" style="width: 10%;" >
                        Farmer
                        </th>
                        <th scope="col" style="width: 5%;" >
                        Crops
                        </th>

                        <th >
                          <div class=" d-flex justify-content-center">
                            <div class="ml-5">
                              Water &nbsp; - &nbsp;
                            </div>
                            <div style="width: 5%; background-color: rgba(117, 190, 218, 0.5);" class="mr-5 "></div>

                            <div >
                              Fertilizer &nbsp; - &nbsp;
                            </div>
                            <div style="width: 5%;  background-color: rgba(75, 192, 192);" class="mr-5"></div>

                            <div class="d-flex">
                              Pesticide &nbsp; - &nbsp;
                            </div>
                            <div style="width: 5%; background-color: rgba(153, 102, 255);" class="mr-5y"></div>
                          </div>
                        </th>
                      </tr>

                    </thead>
                    <tbody>

                      @foreach($FA_counts as $key1 => $FA_count)
                        @if($FA_counts[$key1] != 0)
                          <tr>
                            <th id="Ttip{{$key1}}" style="cursor:pointer; color: #248139;"   data-toggle="modal" data-target="#activity_{{$key1}}">{{$Farmers[$key1]}}</th>
                            <td>{{$N_crops[$key1]}}</td>
                            <td>
                              <div style="width: 100%;" class=" d-flex ">
                                <div id="{{$key1}}{{ $FA_percents[$key1][0] < 5 ? $FA_counts[$key1][0]  : '' }}" title="{{$FA_percents[$key1][0]}}%" class="p-1 rounded-left" style="width: {{$FA_percents[$key1][0]}}%; background-color: rgba(117, 190, 218, 0.5); font-size: 13px;">
                                  @if($FA_percents[$key1][0] < 5)
                                    &nbsp;
                                  @else 
                                    {{$FA_percents[$key1][0]}}%
                                  @endif
                                </div>
                                <div id="{{$key1}}{{ $FA_percents[$key1][1] < 5 ? $FA_counts[$key1][1]  : ''}}" title="{{$FA_percents[$key1][1]}}%" class="p-1" style="width: {{$FA_percents[$key1][1]}}%; background-color: rgba(75, 192, 192); font-size: 13px;">
                                  @if($FA_percents[$key1][1] < 5)
                                    &nbsp;
                                  @else 
                                    {{$FA_percents[$key1][1]}}%
                                  @endif
                                </div>
                                <div id="{{$key1}}{{ $FA_percents[$key1][2] < 5 ? $FA_counts[$key1][2]  : ''}}" title="{{$FA_percents[$key1][2]}}%" class="rounded-right p-1"  style="width: {{$FA_percents[$key1][2]}}%; background-color: rgba(153, 102, 255); font-size: 13px;">

                                  @if($FA_percents[$key1][2] < 5)
                                    &nbsp;
                                  @else 
                                    {{$FA_percents[$key1][2]}}%
                                  @endif
                                </div>

                              </div>
                              <script>
                                $(function () {
                                  $('#{{$key1}}{{$FA_counts[$key1][0]}}').tooltip({placement: "left"})
                                  $('#{{$key1}}{{$FA_counts[$key1][0]}}').tooltip("show")
                                })
                                $(function () {
                                  $('#{{$key1}}{{$FA_counts[$key1][1]}}').tooltip({placement: "left"})
                                  $('#{{$key1}}{{$FA_counts[$key1][1]}}').tooltip("show")
                                })
                                $(function () {
                                  $('#{{$key1}}{{$FA_counts[$key1][2]}}').tooltip({placement: "top"})
                                  $('#{{$key1}}{{$FA_counts[$key1][2]}}').tooltip("show")
                                })
                              </script>


                              <!-- Farming Activities Modal -->
                              <div class="modal fade rounded" id="activity_{{$key1}}" tabindex="-1" role="dialog" aria-labelledby="classInfo" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content rounded">

                                  <div class="modal-header p-1 d-flex justify-content-left">
                                    <h4 class="modal-title ml-2 " style="color: #248139;">{{$Farmers[$key1]}}</h4>
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
                                            <div style="width: 5%; background-color: rgba(117, 190, 218, 0.5);" class="mr-5"></div>

                                            <div>
                                              Fertilizer - 
                                            </div>
                                            <div style="width: 5%; background-color: rgba(75, 192, 192);" class="mr-5 "></div>
  
                                            <div class="d-flex">
                                              Pesticide -   
                                            </div>
                                            <div style="width: 5%; background-color: rgba(153, 102, 255);" class="mr-5 "></div>
                                            
                                          </th>
                                        </tr>
                                      </thead>
                                      <tbody>

                                      @for($i = 0; $i <= $FD_counters[$key1]-1; $i++)
                                        <tr >
                                          <th class="">
                                              {{$FD_crops[$key1][$i]->crop->name}}
                                          </th >
                                          <td class="">{{$FD_hectares[$key1][$i]}}</td>
                                          <td class="w-100 ">
                                            <div class="d-flex justify-content-center">
                                              <div id="water{{$key1}}{{$i}}" title="Water: {{$FD_percents[$key1][$i][0]}}% ({{$FD_counts[$key1][$i][0]}})" class="show0 rounded-left" style="cursor: pointer; width: {{$FD_percents[$key1][$i][0]}}%; background-color: rgba(117, 190, 218, 0.5); font-size: 13px;">
                                                  &nbsp;
                                              </div>
                                              <div id="fertilizer{{$key1}}{{$i}}" title="Fertilizer: {{$FD_percents[$key1][$i][1]}}% ({{$FD_counts[$key1][$i][1]}})" class="show1" style="cursor: pointer; width: {{$FD_percents[$key1][$i][1]}}%; background-color: rgba(75, 192, 192); font-size: 13px;">
                                                  &nbsp;
                                              </div>
                                              <div id="pesticide{{$key1}}{{$i}}" title="Pesticide: {{$FD_percents[$key1][$i][2]}}% ({{$FD_counts[$key1][$i][2]}})" class=" rounded-right show2" style="cursor: pointer; width: {{$FD_percents[$key1][$i][2]}}%; background-color: rgba(153, 102, 255); font-size: 13px;">
                                                  &nbsp;
                                              </div>
                                            </div>
                                          </td>
                                          <script>
                                                $('#water{{$key1}}{{$i}}').tooltip();
                                            
                                                $('#fertilizer{{$key1}}{{$i}}').tooltip();

                                                $('#pesticide{{$key1}}{{$i}}').tooltip();
                                          </script>
                                        </tr>

                                      @endfor      
                                      </tbody>
                                    </table>
                                </div>
                                </div>
                              </div>
                              <!-- /Farming Activities Modal -->

                            </td>
                          </tr>
                        @endif
                      @endforeach
                      
                    </tbody>
                  </table>
                </div>
    
                <form id="cropmonitoringPDF" action="{{ route('generatePDF') }}" method="get">
                  @csrf
                  <input type="hidden" name="barangay" value="{{$pdfbrgy}}">
                  <input type="hidden" name="year_id" value="{{$jsyear}}">
                </form>

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

<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0/dist/chartjs-plugin-datalabels.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
<script>
  const data = {
        labels: @json($n_farmers),
        datasets: [
          {
            label: 'Bitter Gourd',
            data: @json($Bitter_gourds), 
            barThickness: 25,
            backgroundColor:'rgba(182, 207, 182)'
          },{
            label: 'Cabbage',
            data: @json($Cabbages), 
            barThickness: 25,
            backgroundColor:'rgba(171, 222, 230)'
          },{
            label: 'Corn',
            data: @json($Corns), 
            barThickness: 25,
            backgroundColor:'rgba(255, 229, 180)'
          },{
            label: 'Eggplant',
            data: @json($Eggplants), 
            barThickness: 25,
            backgroundColor:'rgba(224, 187, 228)'
          },{
            label: 'Garlic',
            data: @json($Garlics), 
            barThickness: 25,
            backgroundColor:'rgba(236, 234, 228)'
          },{
            label: 'Ladys Finger',
            data: @json($Ladys_fingers), 
            barThickness: 25,
            backgroundColor:'rgba(212, 240, 240)'
          },{
            label: 'Rice',
            data: @json($Rices), 
            barThickness: 25,
            backgroundColor:'rgba(199, 206, 234)'
          },{
            label: 'Onion',
            data: @json($Onions), 
            barThickness: 25,
            backgroundColor:'rgba(236, 213, 227)'
          },{
            label: 'Peanut',
            data: @json($Peanuts), 
            barThickness: 25,
            backgroundColor:'rgba(246, 234, 194)'
          },{
            label: 'String Beans',
            data: @json($String_beans), 
            barThickness: 25,
            backgroundColor:'rgba(186,255,201)'
          },{
            label: 'Tobacco',
            data: @json($Tobaccos), 
            barThickness: 25,
            backgroundColor:'rgba(202, 255,191)'
          },{
            label: 'Tomato',
            data: @json($Tomatos), 
            barThickness: 25,
            backgroundColor:'rgba(255, 200, 162)'
          },{
            label: 'Water Melon',
            data: @json($Water_melons), 
            barThickness: 25,
            backgroundColor:'rgba(255, 255, 186)'
          }
        ]
    };

    for(var i = 0; i <= data.datasets.length-1; i++){
      if(data.datasets[i].data.every( e  => e == null))
      {
        data.datasets.splice(i, 1);
        i--;
      }
    }

    const bgColor = {
      id : 'bgColor',
      beforeDraw: (chart, options) => {
      const  {ctx, width, height} = chart;
        ctx.fillStyle = 'white';
        ctx.fillRect(0,0, width, height)
        ctx.restore();
      }
    }


    const config = {
      type: 'bar',
      data ,
      options: {
        responsive: true,
        indexAxis: 'y',
        scales: {
          x: {
            stacked: true,
            ticks: {
                // Include a dollar sign in the ticks
                callback: function(value, index, ticks) {
                    return value + '%';
                }
            },
            title: {
              display: true,
              text: 'Percentage %'
            }
          },
          y: {
            stacked: true,
            title: {
              display: true,
              text: 'List of Farmers'
            }
          }
        },
        plugins: {
          legend: {
            onClick: (evt,   legendItem, legend) => {
              const datasets = legend.legendItems.map((dataset, index) =>{
                  return dataset.text
              });

              const index = datasets.indexOf(legendItem.text);

              if(legend.chart.isDatasetVisible(index) === true)
              {
                legend.chart.hide(index);
              } else {
                legend.chart.show(index);
              }
            },
            labels: {
              generateLabels: (chart) => {
                let visibility1 = [];
                let fillS = [];
                let strokeS = [];
                let text = []

                
                for(let i = 0; i <= data.datasets.length-1; i++)
                {
                  if(chart.data.datasets[i].data.every( e  => e == null) == true || chart.isDatasetVisible(i) == false)
                  {
                    fillS[i] = 'rgb(255,255,255)';
                    strokeS[i] = 'rgb(255,255,255)';
                    visibility1.push(true);
                  }else{
                    fillS[i] = chart.data.datasets[i].backgroundColor;
                    strokeS[i] = 'rgb(255,255,255)';
                    visibility1.push(false);
                  }
                }

                return chart.data.datasets.map(
                  (dataset, index) => ({
                    text: dataset.label,
                    fillStyle: fillS[index],
                    strokeStyle: strokeS[index],
                    hidden: visibility1[index]
                  })
                )
              }
            }
          },
          datalabels: {
            formatter: (value, context) => {
              if(value != null)
              {
                return `${value}%`;
              }
            }
          }
        }
      },
      plugins: [ChartDataLabels,bgColor]
    };

  const myChart = new Chart(
      document.getElementById('myChart'),
      config
    );

  var today = new Date();
  var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();

  const jsbrgy = @json($jsbrgy);
  
  const jsyear = @json($jsyear);
  const technician = @json($technician);

  function downloadPDF()
  {
    const canvas = document.getElementById('myChart');
    
    const canvasImage = canvas.toDataURL('image/jpeg', 1.0);

    let pdf = new jsPDF();
    pdf.setFontSize(10);
    pdf.text('Date Report Generated:', 130, 16);
    pdf.text(date, 170, 16);
    pdf.line(00, 18, 250, 18);
    pdf.setFontSize(12);
    pdf.setFontType('bold');
    pdf.text('PROPOSED SYSTEM', 80, 28);
    pdf.setFontSize(10);
    pdf.setFontType('normal');
    pdf.text('Report on Total Yield of Every Farmer', 73, 32);
    pdf.text('in Barangay', 70, 36);
    pdf.text(jsbrgy, 90, 36);
    console.log(pdf.text(jsbrgy, 90, 36));
    pdf.text('in Year ', 90+jsbrgy.length, 36);
    pdf.text(jsyear, 109+jsbrgy.length, 36);
    pdf.setTextColor(0,0,0);

    pdf.text('The Total Number of Crops Sown in Barangay Quiling Sur', 58, 48);
    pdf.addImage(canvasImage, 'JPEG', 5, 53, 200, 100);

    pdf.setFontSize(10);
    pdf.text('Verified by:', 30, 170);
    pdf.text(technician, 30, 180);

    pdf.setFontSize(9);
    pdf.setFontType('normal');
    pdf.text('Technician', 30, 184);

    pdf.setFontType('normal');
    pdf.text('Page 1', 175, 285);
    
    pdf.save('CropMonitoringChartReport.pdf');

    $('form[id=cropmonitoringPDF]').submit();

  }


</script>
@endsection


