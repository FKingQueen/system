@extends('layouts.layout')

@section('css')
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.min.js" integrity="sha512-vBmx0N/uQOXznm/Nbkp7h0P1RfLSj0HQrFSzV8m7rOGyj30fYAOKHYvCNez+yM8IrfnW0TCodDEjRqf6fodf/Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

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

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
              <div style="width: 100%; margin: auto;">
                <canvas  style="height: 50px;" id="barChart"></canvas>
              </div>

              <!-- <form action="{{ route('cropMonitoring') }}" method="GET">
                @csrf
                <div class="d-flex justify-content-between">
                  <div class="d-flex justify-content-left mb-3">
                    <div>
                      <label for="municipality_id" class="input-group">Municipality</label>
                      <select id="municipality_id" type="text" name="municipality_id" class="custom-select form-control-border @error('municipality_id') is-invalid @enderror" name="municipality_id" required autocomplete="municipality_id" autofocus>
                          <option disabled selected>--- Select Municipality ---</option>
                          <option value="1">Badoc</option>
                          <option value="2">Banna</option>
                          <option value="3">Batac City</option>
                          <option value="4">Currimao</option>
                          <option value="5">Dingras</option>
                          <option value="6">Marcos</option>
                          <option value="7">Nueva Era</option>
                          <option value="8">Paoay</option>
                          <option value="9">Pinili</option>
                          <option value="10">San Nicolas</option>
                          <option value="11">Solsona</option>
                      </select>
                        @error('municipality_id')
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                        @enderror          
                    </div>

                    <div class="ml-3">
                      <label for="year_id" class="input-group">Year</label>
                      <select id="year_id" type="text" name="year_id" class="custom-select form-control-border @error('year_id') is-invalid @enderror" name="year_id" required autocomplete="year_id" autofocus>
                          <option disabled selected>--- Select  Year ---</option>
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
              </form> -->

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

<script data-cfasync="false" src="https://adminlte.io/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script src="https://adminlte.io/themes/AdminLTE/bower_components/jquery/dist/jquery.min.js"></script>

<script src="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<script src="https://adminlte.io/themes/AdminLTE/bower_components/fastclick/lib/fastclick.js"></script>

<script src="https://adminlte.io/themes/AdminLTE/dist/js/adminlte.min.js"></script>

<script src="https://adminlte.io/themes/AdminLTE/dist/js/demo.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.min.js" integrity="sha512-vBmx0N/uQOXznm/Nbkp7h0P1RfLSj0HQrFSzV8m7rOGyj30fYAOKHYvCNez+yM8IrfnW0TCodDEjRqf6fodf/Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


<script>
  $(function(){
    var cropCs = <?php echo json_encode($cropCs); ?>;
    var barCanvas = $("#barChart");
    var barChart = new Chart(barCanvas,{
      type: 'bar',
      data:{
        labels:['Bitter Gourd', 'Corn', 'Ladys Finger', 'Rice', 'String Beans', 'Corn', 'Ladys Finger', 'Rice', 'String Beans'],
        datasets:[
          {
            label: 'Total Crop',
            data:cropCs,
            backgroundColor:['green', 'green', 'green', 'green', 'green']
          }
        ]
      },
      options:{
        scales:{
          yAxes:[{
            ticks:{
              beginAtZero:true
            }
          }]
        }
      }
    });
  });
</script>

@endsection