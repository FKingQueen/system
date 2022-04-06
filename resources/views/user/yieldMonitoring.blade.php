@extends('layouts.layout')

@section('css')

@endsection

@section('content')

  <!-- Content Header (Page header) -->
  <div class="content-header">
      <div class="container-fluid">
      <div class="row">
          <div class="col-sm-6">
              <h1 class="m-0 farm_title">Yield Monitoring</h1>
          </div>
          <!-- /.col -->
      </div><!-- /.row -->
      </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

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
                  <button type="submit" class="btn btn-sm btn-block btn-primary input-group"> Search </button>
              </div>

          </div>

        </div>
      </div>
    </form>
  </div>
  <!-- /.card-body -->



  <!-- Main content -->
  <section class="content mb-4">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <!-- /.card-header -->
            <h5 class="text-center mt-3">The total yield on different types of crops</h5>
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
            <h5 class="text-center mt-3">The total yield of every farmer on different crops</h5>
            <canvas id="farmerChart" width="400" height="150"></canvas>
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
<!-- Crops Chart -->
<script>
  
const ctx1 = document.getElementById('cropsChart').getContext('2d');
const cropsChart = new Chart(ctx1, {
    type: 'bar',
    data: {
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
                'rgba(75, 192, 192, 0.7)',
                'rgba(153, 102, 255, 0.7)',
                'rgba(255, 159, 64, 0.7)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1,
            barThickness: 40
        }]
    },
    options: {
      responsive: true,
      scales: {
          y: {
              beginAtZero: true,
              title: {
                display: true,
                text: 'tons(t)'
              },
              ticks: {
                // Include a dollar sign in the ticks
                callback: function(value, index, ticks) {
                    return value + '(t)';
                }
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
    plugins: [ChartDataLabels]
});
</script>
<!-- /Crops Chart -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0/dist/chartjs-plugin-datalabels.min.js"></script>
<!-- Farmer Chart -->
<script>
var ctx2 = document.getElementById('farmerChart').getContext('2d');
const i = 0;
var farmerChart = new Chart(ctx2, {
    type: 'bar',
    data: {
      labels: @json($n_farmers),
        datasets:[
          {
            label: 'Bitter Gourd',
            data: @json($Bitter_gourds), 
            barThickness: 25,
            
            backgroundColor:'rgba(255, 99, 132, 0.7)',
            borderColor:'rgba(255, 99, 132, .8)',
            borderWidth: .1
          },{
            label: 'Cabbage',
            data: @json($Cabbages), 
            barThickness: 25,
            
            backgroundColor:'rgba(54, 162, 235, 0.7)',
            borderColor:'rgba(54, 162, 235, 0.8)',
            borderWidth: .1
          },{
            label: 'Corn',
            data: @json($Corns), 
            barThickness: 25,
            
            backgroundColor:'rgba(255, 206, 86, 0.7)',
            borderColor:'rgba(255, 206, 86, 0.8)',
            borderWidth: .1
          },{
            label: 'Eggplant',
            data: @json($Eggplants), 
            barThickness: 25,
            
            backgroundColor:'rgba(75, 192, 192, 0.7)',
            borderColor:'rgba(75, 192, 192, 0.8)',
            borderWidth: .1
          },{
            label: 'Garlic',
            data: @json($Garlics), 
            barThickness: 25,
            
            backgroundColor:'rgba(153, 102, 255, 0.7)',
            borderColor:'rgba(153, 102, 255, 0.8)',
            borderWidth: .1
          },{
            label: 'Ladys Finger',
            data: @json($Ladys_fingers), 
            barThickness: 25,
            
            backgroundColor:'rgba(255, 159, 64, 0.7)',
            borderColor:'rgba(255, 159, 64, 0.8)',
            borderWidth: .1
          },{
            label: 'Rice',
            data: @json($Rices), 
            barThickness: 25,
            
            backgroundColor:'rgba(255, 99, 132, 0.7)',
            borderColor:'rgba(255, 99, 132, 0.8)',
            borderWidth: .1
          },{
            label: 'Onion',
            data: @json($Onions), 
            barThickness: 25,
            
            backgroundColor:'rgba(54, 162, 235, 0.7)',
            borderColor:'rgba(54, 162, 235, 0.8)',
            borderWidth: .1
          },{
            label: 'Peanut',
            data: @json($Peanuts), 
            barThickness: 25,
            
            backgroundColor:'rgba(255, 206, 86, 0.7)',
            borderColor:'rgba(255, 206, 86, 0.8)',
            borderWidth: .1
          },{
            label: 'String Beans',
            data: @json($String_beans), 
            barThickness: 25,
            
            backgroundColor:'rgba(75, 192, 192, 0.7)',
            borderColor:'rgba(75, 192, 192, 0.8)',
            borderWidth: .1
          },{
            label: 'Tobacco',
            data: @json($Tobaccos), 
            barThickness: 25,
            backgroundColor:'rgba(153, 102, 255, 0.7)',
            borderColor:'rgba(153, 102, 255, 0.8)',
            borderWidth: .1
          },{
            label: 'Tomato',
            data: @json($Tomatos), 
            barThickness: 25,
            
            backgroundColor:'rgba(255, 159, 64, 0.7)',
            borderColor:'rgba(255, 159, 64, 0.8)',
            borderWidth: .1
          },{
            label: 'Water Melon',
            data: @json($Water_melons), 
            barThickness: 25,
            
            backgroundColor:'rgba(255, 99, 132, 0.7)',
            borderColor:'rgba(255, 99, 132, .8)',
            borderWidth: .1
          }
        ]
    },
    options: {
      responsive: true,
      indexAxis: 'y',
      scales: {
        x: {
          stacked: true,
          ticks: {
              // Include a dollar sign in the ticks
              callback: function(value, index, ticks) {
                  return value + '(t)';
              }
          },
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
    plugins: [ChartDataLabels]
});


// var sample = @json($Corns);
//   if(sample.every( e  => e == 0.00) == true) {
//     farmerChart.options.plugins.legend = false;
//   }




</script>
<!-- /Farmer Chart -->
@endsection