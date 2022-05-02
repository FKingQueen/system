@extends('layouts.layout')

@section('css')
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
</style>
@endsection

@section('content')

  <!-- Content Header (Page header) -->
  <div class="content-header">
      <div class="container-fluid">
      <div class="row">
          <div  class="col-sm-6" id="target">
              <h1 class="m-0 farm_title">Yield Monitoring</h1>
          </div>
          <!-- /.col -->
      </div><!-- /.row -->
      </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

    <!-- Main content -->
    <section class="content ">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <!-- /.card-header -->
            <div class="card-body p-0">
              <form action="{{ route('yieldMonitoringsearch') }}" method="GET">
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
                        <div class="ml-3">
                            <label for="cropping_season" class="input-group">Cropping Season:</label>
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
  <section class="content mb-4" id="target">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <!-- /.card-header -->
            <h5 class="text-center mt-3">Total Yield in Tons of Different Crops in Barangay {{$jsbrgy}} </h5>
            <canvas id="brgyCompareChart" width="400" height="150"></canvas>
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

  <a id="download" type="button" onclick= "downloadPDF()" class="float">
    <i style='color:#ffffff' class="fas fa-file-export fa-lg my-float"></i>
  </a>

  <script>
      $(document).ready(function(){
        $('#download').tooltip({title: "Export to pdf",html: true, placement: "top", animation: true,}); 
      });
    </script>
  

  <!-- Main content -->
  <section class="content mb-4" id="target">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <!-- /.card-header -->
            <h5 class="text-center mt-3">Total Yield in Tons of Different Crops in Barangay {{$jsbrgy}} </h5>
            <canvas id="cropsChart" width="400" height="150"></canvas>
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
            <h5 class="text-center mt-3">Total Yield in Tons of Every Farmer in Barangay {{$jsbrgy}}</h5>
            <canvas  id="farmerChart" width="400" height="150"></canvas>
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
            <h5 class="text-center mt-3">The Total Hectare on Different Types of Crops in Barangay {{$jsbrgy}}</h5>
            <canvas  id="hectareChart" width="400" height="150"></canvas>
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

@endsection


@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0/dist/chartjs-plugin-datalabels.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>

<!-- Brgy Compare Chart -->
<script>
  const data4 = {
        labels: @json($n_brgys),
        datasets: [
          {
            label: 'Bitter Gourd',
            data: @json($Bitter_gourds_com), 
            barThickness: 25,
            backgroundColor:'rgba(182, 207, 182)'
          },{
            label: 'Cabbage',
            data: @json($Cabbages_com), 
            barThickness: 25,
            backgroundColor:'rgba(171, 222, 230)'
          },{
            label: 'Corn',
            data: @json($Corns_com), 
            barThickness: 25,
            backgroundColor:'rgba(255, 229, 180)'
          },{
            label: 'Eggplant',
            data: @json($Eggplants_com), 
            barThickness: 25,
            backgroundColor:'rgba(224, 187, 228)'
          },{
            label: 'Garlic',
            data: @json($Garlics_com), 
            barThickness: 25,
            backgroundColor:'rgba(236, 234, 228)'
          },{
            label: 'Ladys Finger',
            data: @json($Ladys_fingers_com), 
            barThickness: 25,
            backgroundColor:'rgba(212, 240, 240)'
          },{
            label: 'Rice',
            data: @json($Rices_com), 
            barThickness: 25,
            backgroundColor:'rgba(199, 206, 234)'
          },{
            label: 'Onion',
            data: @json($Onions_com), 
            barThickness: 25,
            backgroundColor:'rgba(236, 213, 227)'
          },{
            label: 'Peanut',
            data: @json($Peanuts_com), 
            barThickness: 25,
            backgroundColor:'rgba(246, 234, 194)'
          },{
            label: 'String Beans',
            data: @json($String_beans_com), 
            barThickness: 25,
            backgroundColor:'rgba(186,255,201)'
          },{
            label: 'Tobacco',
            data: @json($Tobaccos_com), 
            barThickness: 25,
            backgroundColor:'rgba(202, 255,191)'
          },{
            label: 'Tomato',
            data: @json($Tomatos_com), 
            barThickness: 25,
            backgroundColor:'rgba(255, 200, 162)'
          },{
            label: 'Water Melon',
            data: @json($Water_melons_com), 
            barThickness: 25,
            backgroundColor:'rgba(255, 255, 186)'
          }
        ]
    };
    
    for(var i = 0; i <= data4.datasets.length-1; i++){
      if(data4.datasets[i].data.every( e  => e == 0.00))
      {
        data4.datasets.splice(i, 1);
        i--;
      }
    }
    
    const bgColor4 = {
      id : 'bgColor',
      beforeDraw: (chart, options) => {
      const  {ctx, width, height} = chart;
        ctx.fillStyle = 'white';
        ctx.fillRect(0,0, width, height)
        ctx.restore();
      }
    }

    const config4 = {
      type: 'bar',
      data : data4, 
      options: {
        responsive: true,
        scales: {
          x: {
            stacked: true,
            title: {
              display: true,
              text: 'tons(t)'
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
            onClick: (evt, legendItem, legend) => {
              const datasets = legend.legendItems.map((dataset, index) => {
                  return dataset.text
              });
              const index = datasets.indexOf(legendItem.text);
              if(legend.chart.isDatasetVisible(index) === true){
                legend.chart.hide(index);
              } else{
                legend.chart.show(index);
              }
            },
            labels: {
              generateLabels: (chart) => {
                let visibility1 = [];
                let fillS = [];
                let strokeS = [];
                let text = []

                for(let i = 0; i <= data4.datasets.length-1; i++)
                {
                  if(chart.data.datasets[i].data.every( e  => e == 0.00) == true || chart.isDatasetVisible(i) == false)
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
              if(value != 0)
              {
                return value + '(t)';
              } else {
                return '';
              }
            }
          },

        }
      },
    plugins: [ChartDataLabels, bgColor4]
    };
          
    const brgyCompareChart = new Chart(
      document.getElementById('brgyCompareChart'),
      config4
    );
</script>
<!-- /Brgy Compare Chart -->


<!-- Crops Chart -->
<script>



  const data = {
        labels: @json($N_crops),
        datasets: [{
            label: ['tons per crop'],
            data: @json($U_crops),
            backgroundColor: [
              'rgba(182, 207, 182)',
              'rgba(171, 222, 230)',
              'rgba(255, 229, 180)',
              'rgba(224, 187, 228)',
              'rgba(236, 234, 228)',
              'rgba(212, 240, 240)',
              'rgba(199, 206, 234)',
              'rgba(236, 213, 227)',
              'rgba(246, 234, 194)',
              'rgba(186, 255, 201)',
              'rgba(202, 255,191)',
              'rgba(255, 200, 162)',
              'rgba(255, 255, 186)'
            ],
            borderColor: [
              'rgba(182, 207, 182)',
              'rgba(171, 222, 230)',
              'rgba(255, 229, 180)',
              'rgba(224, 187, 228)',
              'rgba(236, 234, 228)',
              'rgba(212, 240, 240)',
              'rgba(199, 206, 234)',
              'rgba(236, 213, 227)',
              'rgba(246, 234, 194)',
              'rgba(186, 255, 201)',
              'rgba(202, 255, 191)',
              'rgba(255, 200, 162)',
              'rgba(255, 255, 186)'
            ],
            borderWidth: 1,
            barThickness: 40
        }]
    };

    for(var i = 0; i <= data.labels.length-1; i++){
      if(data.datasets[0].data[i] == 0)
      {
        data.labels.splice(i, 1);
        data.datasets[0].data.splice(i, 1);
        data.datasets[0].backgroundColor.splice(i, 1);
        data.datasets[0].borderColor.splice(i, 1);
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
      data, 
      options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                title: {
                  display: true,
                  text: 'tons(t)'
                }
            },
            x: {
              title: {
                display: true,
                text: 'List of Crops'
              },
            }
        },
        plugins: {
          legend: {
            onClick: (evt, legendItem, legend) => {
              const index = legend.chart.data.labels.indexOf(legendItem.text);
              legend.chart.toggleDataVisibility(index)
              legend.chart.update()
            },
            labels: {
              generateLabels: (chart) => {
                let visibility = [];
                let bColor = [];
                let bkgColor = [];
                for(let i = 0; i < chart.data.labels.length; i++){
                  if(chart.getDataVisibility(i) === true && chart.data.datasets[0].data[i] != 0) {
                    bColor[i] = chart.data.datasets[0].borderColor[i];
                    bkgColor[i] = chart.data.datasets[0].backgroundColor[i];
                    visibility.push(false);
                  }else{
                    bColor[i] = 'rgb(255,255,255)';
                    bkgColor[i] = 'rgb(255,255,255)';
                    visibility.push(true);
                  }
                }
                return chart.data.labels.map(
                  (label, index) => ({
                    text: label,
                    strokeStyle: bColor[index],
                    fillStyle: bkgColor[index],
                    hidden: visibility[index],
                    
                  })
                  
                )
              }
            }
          },
          datalabels: {
            formatter: (value, context) => {
              if(value != 0)
              {
                return value + '(t)';
              } else {
                return '';
              }
            }
          }
        }
      },
      plugins: [ChartDataLabels, bgColor]
    };


    const cropsChart = new Chart(
      document.getElementById('cropsChart'),
      config
    );

    

</script>
<!-- /Crops Chart -->

<!-- Farmer Chart -->
<script>
  const data1 = {
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
    
    for(var i = 0; i <= data1.datasets.length-1; i++){
      if(data1.datasets[i].data.every( e  => e == 0.00))
      {
        data1.datasets.splice(i, 1);
        i--;
      }
    }
    
    const bgColor1 = {
      id : 'bgColor',
      beforeDraw: (chart, options) => {
      const  {ctx, width, height} = chart;
        ctx.fillStyle = 'white';
        ctx.fillRect(0,0, width, height)
        ctx.restore();
      }
    }

    const config1 = {
      type: 'bar',
      data : data1, 
      options: {
        responsive: true,
        indexAxis: 'y',
        scales: {
          x: {
            stacked: true,
            title: {
              display: true,
              text: 'tons(t)'
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
            onClick: (evt, legendItem, legend) => {
              const datasets = legend.legendItems.map((dataset, index) => {
                  return dataset.text
              });
              const index = datasets.indexOf(legendItem.text);
              if(legend.chart.isDatasetVisible(index) === true){
                legend.chart.hide(index);
              } else{
                legend.chart.show(index);
              }
            },
            labels: {
              generateLabels: (chart) => {
                let visibility1 = [];
                let fillS = [];
                let strokeS = [];
                let text = []

                for(let i = 0; i <= data1.datasets.length-1; i++)
                {
                  if(chart.data.datasets[i].data.every( e  => e == 0.00) == true || chart.isDatasetVisible(i) == false)
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
              if(value != 0)
              {
                return value + '(t)';
              } else {
                return '';
              }
            }
          },

        }
      },
    plugins: [ChartDataLabels, bgColor1]
    };
          
    const farmerChart = new Chart(
      document.getElementById('farmerChart'),
      config1
    );
</script>
<!-- /Farmer Chart -->

<!-- Hectare Chart -->
<script>

  const data2 = {
        labels: @json($N_crops),
        datasets: [{
            label: ['tons per crop'],
            data: @json($H_crops),
            backgroundColor: [
              'rgba(182, 207, 182)',
              'rgba(171, 222, 230)',
              'rgba(255, 229, 180)',
              'rgba(224, 187, 228)',
              'rgba(236, 234, 228)',
              'rgba(212, 240, 240)',
              'rgba(199, 206, 234)',
              'rgba(236, 213, 227)',
              'rgba(246, 234, 194)',
              'rgba(186, 255, 201)',
              'rgba(202, 255,191)',
              'rgba(255, 200, 162)',
              'rgba(255, 255, 186)'
            ],
            borderColor: [
              'rgba(182, 207, 182)',
              'rgba(171, 222, 230)',
              'rgba(255, 229, 180)',
              'rgba(224, 187, 228)',
              'rgba(236, 234, 228)',
              'rgba(212, 240, 240)',
              'rgba(199, 206, 234)',
              'rgba(236, 213, 227)',
              'rgba(246, 234, 194)',
              'rgba(186, 255, 201)',
              'rgba(202, 255, 191)',
              'rgba(255, 200, 162)',
              'rgba(255, 255, 186)'
            ],
            borderWidth: 1,
            barThickness: 40
        }]
    };

    for(var i = 0; i <= data2.labels.length-1; i++){
      if(data2.datasets[0].data[i] == 0)
      {
        data2.labels.splice(i, 1);
        data2.datasets[0].data.splice(i, 1);
        data2.datasets[0].backgroundColor.splice(i, 1);
        data2.datasets[0].borderColor.splice(i, 1);
        i--;
      }
    }

    const bgColor2 = {
      id : 'bgColor',
      beforeDraw: (chart, options) => {
      const  {ctx, width, height} = chart;
        ctx.fillStyle = 'white';
        ctx.fillRect(0,0, width, height)
        ctx.restore();
      }
    }

    const config2 = {
      type: 'bar',
      data: data2, 
      options: {

        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                title: {
                  display: true,
                  text: 'Hectare(h)'
                }
            },
            x: {
              title: {
                display: true,
                text: 'List of Crops'
              },
            }
        },
        plugins: {
          legend: {
            onClick: (evt, legendItem, legend) => {
              const index = legend.chart.data.labels.indexOf(legendItem.text);
              legend.chart.toggleDataVisibility(index)
              legend.chart.update()
            },
            labels: {
              generateLabels: (chart) => {
                let visibility2 = [];
                let bColor2 = [];
                let bkgColor2 = [];
                for(let i = 0; i < chart.data.labels.length; i++){
                  if(chart.getDataVisibility(i) === true && chart.data.datasets[0].data[i] != 0) {
                    bColor2[i] = chart.data.datasets[0].borderColor[i];
                    bkgColor2[i] = chart.data.datasets[0].backgroundColor[i];
                    visibility2.push(false);
                  }else{
                    bColor2[i] = 'rgb(255,255,255)';
                    bkgColor2[i] = 'rgb(255,255,255)';
                    visibility2.push(true);
                  }
                }
                return chart.data.labels.map(
                  (label, index) => ({
                    text: label,
                    strokeStyle: bColor2[index],
                    fillStyle: bkgColor2[index],
                    hidden: visibility2[index],
                    
                  })
                  
                )
              }
            }
          },
          datalabels: {
            formatter: (value, context) => {
              if(value != 0)
              {
                return value + '(h)';
              } else {
                return '';
              }
            }
          }
        }
      },
      plugins: [ChartDataLabels, bgColor2]
    };


    const hectareChart = new Chart(
      document.getElementById('hectareChart'),
      config2
    );

    var today = new Date();
    var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();

    const jsbrgy = @json($jsbrgy);
    const jsyear = @json($jsyear);
    const jscs = @json($jscs);
    const technician = @json($technician);

    function downloadPDF()
    {
      const canvas1 = document.getElementById('farmerChart');
      const canvas2 = document.getElementById('cropsChart');
      const canvas3 = document.getElementById('hectareChart');
      
      const canvasImage1 = canvas1.toDataURL('image/jpeg', 1.0);
      const canvasImage2 = canvas2.toDataURL('image/jpeg', 1.0);
      const canvasImage3 = canvas3.toDataURL('image/jpeg', 1.0);


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
      pdf.text('Report on Total Yield of every Farmer', 73, 32);
      pdf.text('in Barangay', 85, 36);
      pdf.text(jsbrgy, 105, 36);
      pdf.setTextColor(0,0,0);
      pdf.text('Year:', 15, 48);
      pdf.text(jsyear, 25, 48);
      pdf.text('Cropping Season:', 145, 48);
      pdf.text(jscs, 175, 48);

      pdf.text('The Total Yield on Different Types of Crops in Tons', 61, 60);
      pdf.addImage(canvasImage2, 'JPEG', 5, 63, 200, 100);

      pdf.text('The Total Yield of Every Farmer in Tons', 71, 173);
      pdf.addImage(canvasImage1, 'JPEG', 5, 177, 200, 100);

      pdf.setFontSize(8);
      pdf.setFontType('normal');
      pdf.text('Page 1', 175, 285);

      pdf.addPage();
      pdf.setFontSize(10);
      pdf.setFontType('normal');
      pdf.text('Date Report Generated:', 130, 16);
      pdf.text(date, 170, 16);
      pdf.line(00, 18, 250, 18);

      pdf.text('The Total Hectare on Different Types of Crops', 68, 27);
      pdf.addImage(canvasImage3, 'JPEG', 5, 31, 200, 100);

      pdf.text('Verified by:', 30, 140);
      pdf.text(technician, 30, 150);

      pdf.setFontSize(9);
      pdf.setFontType('normal');
      pdf.text('Technician', 30, 154);

      pdf.setFontSize(8);
      pdf.setFontType('normal');
      pdf.text('Page 2', 175, 285);
      pdf.save('YieldMonitoringReport.pdf');
    }
    

</script>
<!-- /Hectare Chart -->

@endsection


