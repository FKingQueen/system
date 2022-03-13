@extends('layouts.layout')

@section('css')

@endsection

@section('content')

  <!-- Content Header (Page header) -->
  <div class="content-header">
      <div class="container-fluid">
      <div class="row">
          <div class="col-sm-6">
              <h1 class="m-0">Crop Monitoring</h1>
          </div>
          <!-- /.col -->
      </div><!-- /.row -->
      </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->


  <div class="card-body">
                
    <form action="{{ route('cropMonitoring') }}" method="GET">
      @csrf
      <div class="modal-body rounded bg-white">
          <div class="d-flex justify-content-left">
              <div>
                  <label for="crop_name" class="input-group">Municipality:</label>
                  <select id="municipality" type="text" name="municipality" class="form-control @error('municipality') is-invalid @enderror" name="municipality" required autocomplete="municipality" autofocus>
                      <option value="" disabled selected>--- Select Municipality ---</option>
                      @foreach ($municipalities as $key => $value)
                          <option value="{{ $key }}">{{ $value }}</option>
                      @endforeach
                  </select>
                      @error('municipality')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                      @enderror              
              </div>

              <div class="ml-3">
                  <label for="crop_name" class="input-group">Barangay:</label>
                  <select id="barangay" type="text" name="barangay" class="form-control @error('barangay') is-invalid @enderror" name="barangay" required autocomplete="barangay" autofocus>
                      <option value="" disabled selected>--- Select Barangay ---</option>
                  </select>
                  @error('barangay')
                      <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>   
              <div class="ml-3">
                  <label for="year_id" class="input-group">Year</label>
                  <select id="year_id" type="text" name="year_id" class="custom-select form-control-border @error('year_id') is-invalid @enderror" name="year_id" required autocomplete="year_id" autofocus>
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
                  <button type="submit" class="btn btn-block btn-primary input-group"> FIND </button>
              </div>
          </div>
      </div>
    </form>

  </div>
  <!-- /.card-body -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
              

              

              <div>
                <h4 class="text-center">Sowing-Harvesting Chart</h4>
                <canvas style="position: relative; height:40vh; width:80vw" id="barChart"></canvas>
              </div>

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
            <div class="input-group  d-flex justify-content-center">
              <h3 class="text-center">FARMING ACTIVITIES</h3>
            </div>

            <div class="input-group" >
              <table class="table table-hover text-center">
                <thead>
                  <tr>
                    <th scope="col" style="width: 25%;">Farmer</th>
                    <th scope="col" style="width: 25%;">Water</th>
                    <th scope="col" style="width: 25%;">Fertilizer</th>
                    <th scope="col" style="width: 25%;">Pesticide</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($farmers as $farmer)
                    @php $count = $loop->index @endphp
                    <tr>
                        <th scope="row"> 
                          <a type="button" data-toggle="modal" data-target="#activity_{{$farmer->id}}">
                            {{$farmer->name}}
                          </a>
                        </th>
                        @foreach($Fpercents[$count] as $Fpercent)
                        @php $c = $loop->index @endphp
                          <td>{{$Fpercent}}%</td>
                        @endforeach
                    </tr>
 
                    <!-- Option Modal -->
                    <div class="modal fade rounded" id="activity_{{$farmer->id}}" tabindex="-1" role="dialog" aria-labelledby="classInfo" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered modal-lg">
                      <div class="modal-content rounded">

                        <div class="modal-header p-1 d-flex justify-content-around">
                          <h4 class="modal-title ml-2 ">{{$farmer->name}}</h4>
                          <h4 class="modal-title ml-2 ">Activities</h4>
                        </div>

                        <div class="modal-body rounded bg-white p-0">
                          <div class="d-flex justify-content-between"> 
                              <div class="p-2"> <b>Crops</b> </div>
                              <div class="d-flex justify-content-between w-50"> 
                                <div class="p-2"> <b>Water</b> </div>
                                <div class="p-2"> <b>Pesticide</b> </div>
                                <div class="p-2"> <b>Fertilizer</b> </div>
                              </div>
                          </div>
                        @for($i= 0; $i <= $realCounts[$count]-1; $i++)
                          <div class="d-flex justify-content-between border "> 
                              <div class="p-2">{{$FDcrops[$count][$i]}}</div>
                              <div class="d-flex justify-content-between w-50"> 
                              @foreach($FDvalues[$count][$i] as $FDvalue)
                                <div class="p-2">{{$FDvalue}}%</div>
                              @endforeach
                              </div>
                              
                          </div>
                        @endfor
                        </div>

                      </div>
                      </div>
                    </div>
                    <!-- /Option Modal -->

                  @endforeach
                </tbody>
              </table>
              
              
            </div>

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

<script>
  $(function(){
    var cropCs = <?php echo json_encode($cropCs); ?>;
    var barCanvas = $("#barChart");
    var barChart = new Chart(barCanvas,{
      type: 'bar',
      data:{
        labels:['Bitter Gourd', 'Corn', 'Ladys Finger', 'Rice', 'String Beans'],
        datasets:[
          {
            label: 'Total Crop',
            data:cropCs,
            barThickness: 50,
            minBarLength: 2,
            backgroundColor:['green', 'green', 'green', 'green', 'green']
            
          }
        ]
      },
      options:{
        scales:{
          yAxes:[{
            ticks:{
              beginAtZero:true,
              max: 10
            }
          }]
        }
      }
    });
  });
</script>

@endsection