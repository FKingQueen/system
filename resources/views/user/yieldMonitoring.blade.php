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

  <a id="download" type="button" onclick= "downloadPDF()" class="float">
    <i style='color:#ffffff' class="fas fa-file-export fa-lg my-float"></i>
  </a>

  <script>
      $(document).ready(function(){
        $('#download').tooltip({title: "Export to pdf",html: true, placement: "top", animation: true,}); 
      });
    </script>
  
  <!-- card-body -->
  <div class="card-body">
                
    <form action="{{ route('yieldMonitoringsearch') }}" method="GET">
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

  <!-- Main content -->
  <section class="content mb-4" id="target">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <!-- /.card-header -->
            <h5 class="text-center mt-3">The Total Yield on Different Types of Crops in Tons</h5>
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
            <h5 class="text-center mt-3">The Total Yield of Every Farmer in Tons</h5>
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
            <h5 class="text-center mt-3">The Total Hectare on Different Types of Crops</h5>
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
<!-- Crops Chart -->
<script>



  const data = {
        labels: @json($N_crops),
        datasets: [{
            label: ['tons per crop'],
            data: @json($U_crops),
            backgroundColor: [
                'rgba(255, 99, 132, 0.7)',
                'rgba(54, 162, 235, 0.7)',
                'rgba(255, 206, 86, 0.7)',
                'rgba(75, 192, 192, 0.7)',
                'rgba(153, 102, 255, 0.7)',
                'rgba(255, 159, 64, 0.7)',
                'rgba(255, 99, 132, 0.7)',
                'rgba(54, 162, 235, 0.7)',
                'rgba(255, 206, 86, 0.7)',
                'rgba(75, 192, 192, 0.7)',
                'rgba(153, 102, 255, 0.7)',
                'rgba(255, 159, 64, 0.7)',
                'rgba(255, 99, 132, 0.7)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 0.7)',
                'rgba(54, 162, 235, 0.7)',
                'rgba(255, 206, 86, 0.7)',
                'rgba(75, 192, 192, 0.7)',
                'rgba(153, 102, 255, 0.7)',
                'rgba(255, 159, 64, 0.7)',
                'rgba(255, 99, 132, 0.7)',
                'rgba(54, 162, 235, 0.7)',
                'rgba(255, 206, 86, 0.7)',
                'rgba(75, 192, 192, 0.7)',
                'rgba(153, 102, 255, 0.7)',
                'rgba(255, 159, 64, 0.7)',
                'rgba(255, 99, 132, 0.7)'
            ],
            borderWidth: 1,
            barThickness: 40
        }]
    };
    
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
            
            backgroundColor:'rgba(255, 99, 132, 0.7)',
            borderColor:'rgba(255, 99, 132, .7)',
            borderWidth: .1
          },{
            label: 'Cabbage',
            data: @json($Cabbages), 
            barThickness: 25,
            
            backgroundColor:'rgba(54, 162, 235, 0.7)',
            borderColor:'rgba(54, 162, 235, 0.7)',
            borderWidth: .1
          },{
            label: 'Corn',
            data: @json($Corns), 
            barThickness: 25,
            
            backgroundColor:'rgba(255, 206, 86, 0.7)',
            borderColor:'rgba(255, 206, 86, 0.7)',
            borderWidth: .1
          },{
            label: 'Eggplant',
            data: @json($Eggplants), 
            barThickness: 25,
            
            backgroundColor:'rgba(75, 192, 192, 0.7)',
            borderColor:'rgba(75, 192, 192, 0.7)',
            borderWidth: .1
          },{
            label: 'Garlic',
            data: @json($Garlics), 
            barThickness: 25,
            
            backgroundColor:'rgba(153, 102, 255, 0.7)',
            borderColor:'rgba(153, 102, 255, 0.7)',
            borderWidth: .1
          },{
            label: 'Ladys Finger',
            data: @json($Ladys_fingers), 
            barThickness: 25,
            
            backgroundColor:'rgba(255, 159, 64, 0.7)',
            borderColor:'rgba(255, 159, 64, 0.7)',
            borderWidth: .1
          },{
            label: 'Rice',
            data: @json($Rices), 
            barThickness: 25,
            
            backgroundColor:'rgba(255, 99, 132, 0.7)',
            borderColor:'rgba(255, 99, 132, 0.7)',
            borderWidth: .1
          },{
            label: 'Onion',
            data: @json($Onions), 
            barThickness: 25,
            
            backgroundColor:'rgba(54, 162, 235, 0.7)',
            borderColor:'rgba(54, 162, 235, 0.7)',
            borderWidth: .1
          },{
            label: 'Peanut',
            data: @json($Peanuts), 
            barThickness: 25,
            
            backgroundColor:'rgba(255, 206, 86, 0.7)',
            borderColor:'rgba(255, 206, 86, 0.7)',
            borderWidth: .1
          },{
            label: 'String Beans',
            data: @json($String_beans), 
            barThickness: 25,
            
            backgroundColor:'rgba(75, 192, 192, 0.7)',
            borderColor:'rgba(75, 192, 192, 0.7)',
            borderWidth: .1
          },{
            label: 'Tobacco',
            data: @json($Tobaccos), 
            barThickness: 25,
            backgroundColor:'rgba(153, 102, 255, 0.7)',
            borderColor:'rgba(153, 102, 255, 0.7)',
            borderWidth: .1
          },{
            label: 'Tomato',
            data: @json($Tomatos), 
            barThickness: 25,
            
            backgroundColor:'rgba(255, 159, 64, 0.7)',
            borderColor:'rgba(255, 159, 64, 0.7)',
            borderWidth: .1
          },{
            label: 'Water Melon',
            data: @json($Water_melons), 
            barThickness: 25,
            
            backgroundColor:'rgba(255, 99, 132, .7)',
            borderColor:  'rgba(255, 99, 132, .7 )',
            borderWidth: .1
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

    for(var i = 0; i <= data.datasets.length-1; i++){
      if(data.datasets[i].data.every( e  => e == null))
      {
        data.datasets.splice(i, 1);
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
                    strokeS[i] = chart.data.datasets[i].borderColor;
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
                'rgba(255, 99, 132, 0.7)',
                'rgba(54, 162, 235, 0.7)',
                'rgba(255, 206, 86, 0.7)',
                'rgba(75, 192, 192, 0.7)',
                'rgba(153, 102, 255, 0.7)',
                'rgba(255, 159, 64, 0.7)',
                'rgba(255, 99, 132, 0.7)',
                'rgba(54, 162, 235, 0.7)',
                'rgba(255, 206, 86, 0.7)',
                'rgba(75, 192, 192, 0.7)',
                'rgba(153, 102, 255, 0.7)',
                'rgba(255, 159, 64, 0.7)',
                'rgba(255, 99, 132, 0.7)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 0.7)',
                'rgba(54, 162, 235, 0.7)',
                'rgba(255, 206, 86, 0.7)',
                'rgba(75, 192, 192, 0.7)',
                'rgba(153, 102, 255, 0.7)',
                'rgba(255, 159, 64, 0.7)',
                'rgba(255, 99, 132, 0.7)',
                'rgba(54, 162, 235, 0.7)',
                'rgba(255, 206, 86, 0.7)',
                'rgba(75, 192, 192, 0.7)',
                'rgba(153, 102, 255, 0.7)',
                'rgba(255, 159, 64, 0.7)',
                'rgba(255, 99, 132, 0.7)'
            ],
            borderWidth: 1,
            barThickness: 40
        }]
    };

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
    console.log(technician);
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


