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

  

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
              <form action="{{ route('yieldMonitoring') }}" method="GET">
                @csrf
                <div class="rounded bg-white p-0">
                    <div class="d-flex justify-content-left input-group mb-3 ">
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
                            <label for="year_id" class="input-group">Year</label>
                            <select id="year_id" type="text" name="year_id" class="@error('year_id') is-invalid @enderror form-control form-control-sm" name="year_id" required autocomplete="year_id" autofocus>
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
                            <label for="crop_name" class="input-group">Crop</label>
                            <select id="crop_id" type="text" name="crop_id" class="form-control form-control-sm @error('crop_id') is-invalid @enderror" name="crop_id" required autocomplete="crop_id" autofocus>
                              <option disabled selected>--- Select  Crop ---</option>
                              <option value="1">Bitter Gourd (Ampalaya)</option>
                              <option value="2">Cabbage</option>
                              <option value="3">Corn</option>
                              <option value="4">Eggplant</option>
                              <option value="5">Garlic</option>
                              <option value="6">Ladys Finger (Okra)</option>
                              <option value="7">Rice</option>
                              <option value="8">Onion</option>
                              <option value="9">Peanut</option>
                              <option value="10">String Beans (Sitaw)</option>
                              <option value="11">Tobacco</option>
                              <option value="12">Tomato</option>
                              <option value="13">Water Melon</option>
                            </select>
                                @error('crop_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror          
                        </div>

                        <div class="ml-3">
                            <label for="cropping_season" class="input-group">Cropping Season</label>
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
                            <button type="submit" class="btn btn-sm  btn-block btn-primary input-group"> Search </button>
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
            <canvas id="myChart" width="400" height="150"></canvas>
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
<script>
var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: @json($n_farmers),
        datasets:[
          {
            label: 'Bitter Gourd',
            data: @json($Bitter_gourds), 
            barThickness: 25,
            datalabel: 'naruto',  
            
            backgroundColor:'rgba(255, 99, 132, 0.2)',
          },{
            label: 'Cabbage',
            data: @json($Cabbages), 
            barThickness: 25,
            
            backgroundColor:'rgba(54, 162, 235, 0.2)',
          },{
            label: 'Corn',
            data: @json($Corns), 
            barThickness: 25,
            
            backgroundColor:'rgba(255, 206, 86, 0.2)',
          },{
            label: 'Eggplant',
            data: @json($Eggplants), 
            barThickness: 25,
            
            backgroundColor:'rgba(75, 192, 192, 0.2)',
          },{
            label: 'Garlic',
            data: @json($Garlics), 
            barThickness: 25,
            
            backgroundColor:'rgba(153, 102, 255, 0.2)',
          },{
            label: 'Ladys Finger',
            data: @json($Ladys_fingers), 
            barThickness: 25,
            
            backgroundColor:'rgba(255, 159, 64, 0.2)'
          },{
            label: 'Rice',
            data: @json($Rices), 
            barThickness: 25,
            
            backgroundColor:'rgba(255, 99, 132, 0.2)',
          },{
            label: 'Onion',
            data: @json($Onions), 
            barThickness: 25,
            
            backgroundColor:'rgba(54, 162, 235, 0.2)',
          },{
            label: 'Peanut',
            data: @json($Peanuts), 
            barThickness: 25,
            
            backgroundColor:'rgba(255, 206, 86, 0.2)',
          },{
            label: 'String Beans',
            data: @json($String_beans), 
            barThickness: 25,
            
            backgroundColor:'rgba(75, 192, 192, 0.2)',
          },{
            label: 'Tobacco',
            data: @json($Tobaccos), 
            barThickness: 25,
            
            backgroundColor:'rgba(153, 102, 255, 0.2)',
          },{
            label: 'Tomato',
            data: @json($Tomatos), 
            barThickness: 25,
            
            backgroundColor:'rgba(255, 159, 64, 0.2)'
          },{
            label: 'Water Melon',
            data: @json($Water_melons), 
            barThickness: 25,
            
            backgroundColor:'rgba(255, 159, 64, 0.2)'
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
        datalabels: {
          formatter: (value, context) => {
            if(value != null)
            {
              return `${value}%`;
            }
          }
        },
        legend: {
            display: false
        },
        title: {
            display: true,
            text: 'The total number of crops sown in barangay '
        }
      }
    },
    plugins: [ChartDataLabels]
});
</script>
@endsection