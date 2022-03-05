@extends('layouts.layout')

@section('css')

@endsection

@section('content')

  <!-- Content Header (Page header) -->
  <div class="content-header">
      <div class="container-fluid">
      <div class="row">
          <div class="col-sm-6">
              <h1 class="m-0">Crop Calendar</h1>
          </div>
          <!-- /.col -->
      </div><!-- /.row -->
      </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <div class="p-0 d-flex container-fluid justify-content-center">
    <h5>Year</h5>
  </div>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <!-- /.card-header -->
            <div class="card-body">

            <table class=" p-0" >
                <thead>
                <tr>
                  <td class="p-0"><img src="{{ asset('images/greenline.png')}}" width="100%" alt="Image"></td>
                  <td class="p-0"><img src="{{ asset('images/greenline.png')}}" width="100%" alt="Image"></td>
                  <td class="p-0"><img src="{{ asset('images/greenline.png')}}" width="100%" alt="Image"></td>
                  <td class="p-0"><img src="{{ asset('images/greenline.png')}}" width="100%" alt="Image"></td>
                  <td class="p-0"><img src="{{ asset('images/greenline.png')}}" width="100%" alt="Image"></td>
                </tr>
                <tr>
                    @foreach($years as $year)
                        <td class="p-0 text-center">{{$year}}</td>
                    @endforeach
                </tr>

              </thead>
              <tbody class="p-0">
                <tr class="p-0">
                  <th class="p-0">
                    <div class="p-0 container-fluid text-center">
                        @foreach($crops as $crop)
                            @foreach($percentages[4] as $percentage[0])
                                @if($percentage[0] != 0)
                                    @if($crop->id == $loop->iteration)
                                        <small class="p-0">{{$crop->name}} {{$percentage[0]}} %</small> <br>
                                    @endif
                                @endif
                            @endforeach
                        @endforeach
                    </div>
                  </th>
                  <th class="p-0">
                    <div class="p-0 container-fluid text-center">
                        @foreach($crops as $crop)
                            @foreach($percentages[3] as $percentage[0])
                                @if($percentage[0] != 0)
                                    @if($crop->id == $loop->iteration)
                                        <small class="p-0">{{$crop->name}} {{$percentage[0]}} %</small> <br>
                                    @endif
                                @endif
                            @endforeach
                        @endforeach
                    </div>
                  </th>
                  <th class="p-0">
                    <div class="p-0 container-fluid text-center">
                        @foreach($crops as $crop)
                            @foreach($percentages[2] as $percentage[0])
                                @if($percentage[0] != 0)
                                    @if($crop->id == $loop->iteration)
                                        <small class="p-0">{{$crop->name}} {{$percentage[0]}} %</small> <br>
                                    @endif
                                @endif
                            @endforeach
                        @endforeach
                    </div>
                  </th>
                  <th class="p-0">
                    <div class="p-0 container-fluid text-center">
                        @foreach($crops as $crop)
                            @foreach($percentages[1] as $percentage[0])
                                @if($percentage[0] != 0)
                                    @if($crop->id == $loop->iteration)
                                        <small class="p-0">{{$crop->name}} {{$percentage[0]}} %</small> <br>
                                    @endif
                                @endif
                            @endforeach
                        @endforeach
                    </div>
                  </th>
                  <th class="p-0">
                    <div class="p-0 container-fluid text-center">
                    @foreach($crops as $crop)
                        @foreach($percentages[0] as $percentage[0])
                            @if($percentage[0] != 0)
                                @if($crop->id == $loop->iteration)
                                    <small class="p-0 m-0">{{$crop->name}} {{$percentage[0]}} %</small> <br>
                                @endif
                            @endif
                        @endforeach
                     @endforeach
                    </div>
                  </th>
                </tr>
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

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <!-- /.card-header -->
            <div class="card-body">

              <form action="{{ route('cropCalendar') }}" method="GET">
                @csrf
                <div class="input-group d-flex justify-content-left mb-3">
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
                        @foreach($years as $year)
                          <option value="{{$loop->index}}">{{$year}}</option>
                        @endforeach
                    </select>
                      @error('year_id')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror          
                  </div>
                  <div class="ml-3 d-flex align-items-end"">
                    <button type="submit" class="btn btn-block btn-primary input-group"> FIND </button>
                  </div>
                </div>
              </form>

              <table class="table table-bordered">
                <thead>
                  <tr class="text-center">
                    <th scope="col" style="width: 0%;"></th>
                    <th scope="col" style="width: 8%;">J</th>
                    <th scope="col" style="width: 8%;">F</th>
                    <th scope="col" style="width: 8%;">M</th>
                    <th scope="col" style="width: 8%;">A</th>
                    <th scope="col" style="width: 8%;">M</th>
                    <th scope="col" style="width: 8%;">Jn</th>
                    <th scope="col" style="width: 8%;">Jl</th>
                    <th scope="col" style="width: 8%;">A</th>
                    <th scope="col" style="width: 8%;">S</th>
                    <th scope="col" style="width: 8%;">O</th>
                    <th scope="col" style="width: 8%;">N</th>
                    <th scope="col" style="width: 8%;">D</th>
                  </tr>
                </thead>
                <tbody>
                    @php $i=0 @endphp
                    @php $mc=11 @endphp
                    @foreach($brgys as $brgy)
                      <tr>
                        <td>B{{$brgy->id}}</td>
                        @while($i <=$mc)
                          <td>
                            @foreach($percs[$i] as $perc[0])
                              {{$perc[0]}} % <br>
                            @endforeach
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